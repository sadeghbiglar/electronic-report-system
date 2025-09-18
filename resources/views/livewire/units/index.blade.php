<?php

use Livewire\Attributes\Title;
use Livewire\Volt\Component;
use App\Models\Unit;
use App\Models\Location;
use App\Models\UnitType;
use App\Models\UnitTypeRelationship; // اضافه کردن import
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Mary\Traits\Toast;

new #[Title('مدیریت واحدها')]
class extends Component
{
    use WithPagination, Toast;

    public string $search = '';
    public bool $modal = false;
    public bool $editing = false;
    public ?Unit $editingUnit = null;
    public string $name = '';
    public $type_id = null;
    public $parent_id = null;
    public $location_id = null;
    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];

    public function updatedSearch()
    {
        $this->resetPage(); // ریست صفحه به ۱ هنگام جستجو
    }

    public function updatedTypeId($value)
    {
        $this->parent_id = null; // ریست بالادستی هنگام تغییر نوع
    }

    public function with(): array
    {
        $allowedParents = [];
        if ($this->type_id) {
            $allowedParentTypeIds = UnitTypeRelationship::where('child_type_id', $this->type_id)
                ->pluck('parent_type_id');
            $allowedParents = Unit::whereIn('type_id', $allowedParentTypeIds)
                ->get()
                ->map(fn($unit) => ['value' => $unit->id, 'label' => $unit->name])
                ->toArray();
        } else {
            $allowedParents = Unit::all()
                ->map(fn($unit) => ['value' => $unit->id, 'label' => $unit->name])
                ->toArray();
        }

        return [
            'description' => 'مدیریت واحدهای سازمانی',
            'keywords' => 'واحدها, بهداشت, مدیریت',
            'headers' => [
                ['key' => 'name', 'label' => 'نام', 'class' => 'w-40'],
                ['key' => 'type.label', 'label' => 'نوع', 'class' => 'w-20'],
                ['key' => 'parent.name', 'label' => 'بالادستی', 'class' => 'w-20 hidden xl:table-cell'],
                ['key' => 'location.name', 'label' => 'موقعیت', 'class' => 'w-20 hidden xl:table-cell'],
                ['key' => 'actions', 'label' => 'عملیات', 'class' => 'w-24'],
            ],
            'units' => Unit::query()
                ->with(['type', 'parent', 'location'])
                ->when($this->search, fn($query) => $query->where('name', 'like', "%{$this->search}%"))
                ->orderBy(...array_values($this->sortBy))
                ->paginate(5),
            'types' => UnitType::all()->map(fn($type) => ['value' => $type->id, 'label' => $type->label])->toArray(),
            'parents' => $allowedParents, // استفاده از بالادستی‌های مجاز
            'locations' => Location::all()->map(fn($location) => ['value' => $location->id, 'label' => $location->name])->toArray(),
        ];
    }

    public function openModalForCreate()
    {
        $this->reset(['name', 'type_id', 'parent_id', 'location_id', 'editing', 'editingUnit']);
        $this->modal = true;
    }

    public function openModalForEdit(Unit $unit)
    {
        $this->editingUnit = $unit;
        $this->name = $unit->name;
        $this->type_id = $unit->type_id;
        $this->parent_id = $unit->parent_id;
        $this->location_id = $unit->location_id;
        $this->editing = true;
        $this->modal = true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('units')->ignore($this->editingUnit?->id)],
            'type_id' => ['required', 'exists:unit_types,id'],
            'parent_id' => [
                'nullable', 'exists:units,id',
                Rule::notIn([$this->editingUnit?->id ?? 0]), // جلوگیری از انتخاب خودش
                function ($attribute, $value, $fail) {
                    if ($value && $this->type_id) {
                        $parent = Unit::find($value);
                        $allowedParentTypeIds = UnitTypeRelationship::where('child_type_id', $this->type_id)
                            ->pluck('parent_type_id')
                            ->toArray();
                        if ($parent && !in_array($parent->type_id, $allowedParentTypeIds)) {
                            $fail('واحد بالادستی انتخاب‌شده مجاز نیست.');
                        }
                    }
                },
            ],
            'location_id' => ['nullable', 'exists:locations,id'],
        ];
    }

    public function save()
    {
        $validated = $this->validate();
        try {
            if ($this->editing) {
                $this->editingUnit->update($validated);
                $this->success("واحد '{$this->name}' به‌روزرسانی شد", position: 'toast-bottom');
            } else {
                Unit::create($validated);
                $this->success("واحد '{$this->name}' ایجاد شد", position: 'toast-bottom');
            }
            $this->modal = false;
        } catch (\Exception $e) {
            $this->error('خطا در ذخیره‌سازی', position: 'toast-bottom');
        }
    }

    public function delete(Unit $unit)
    {
        try {
            $unit->delete();
            $this->warning("واحد '{$unit->name}' حذف شد", position: 'toast-bottom');
        } catch (\Exception $e) {
            $this->error('امکان حذف وجود ندارد زیرا در جدول دیگری استفاده شده است.', position: 'toast-bottom');
        }
    }
}
?>

<div>
    <x-header title="مدیریت واحدها" separator progress-indicator class="mb-6">
        <x-slot:middle class="!justify-end">
            <x-input wire:model.live.debounce="search" placeholder="جستجو نام واحد..." clearable icon="o-magnifying-glass" class="w-full sm:w-80 input-bordered bg-white text-black shadow-sm" />
        </x-slot:middle>
        <x-slot:actions>
            <x-button label="ایجاد واحد" wire:click="openModalForCreate" icon="o-plus" class="btn-primary shadow-sm" />
        </x-slot:actions>
    </x-header>

    <x-card shadow class="max-w-7xl mx-auto">
        @if ($units->count() > 0)
            <x-table
                :headers="$headers"
                :rows="$units"
                :sort-by="$sortBy"
                with-pagination
                per-page="5"
            >
                <x-slot name="body">
                    @foreach ($units as $unit)
                        <tr>
                            <td>{{ $unit->name }}</td>
                            <td>{{ $unit->type->label }}</td>
                            <td class="hidden xl:table-cell">{{ $unit->parent?->name ?? '-' }}</td>
                            <td class="hidden xl:table-cell">{{ $unit->location?->name ?? '-' }}</td>
                            <td>
                                @scope('actions', $unit)
                                    <div class="flex gap-2">
                                        <x-button icon="o-pencil" wire:click="openModalForEdit({{ $unit->id }})" class="btn-ghost btn-sm text-primary" />
                                        <x-button icon="o-trash" wire:click="delete({{ $unit->id }})" wire:confirm="مطمئنید؟" class="btn-ghost btn-sm text-error" />
                                    </div>
                                @endscope
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-table>
        @else
            <p class="text-center text-gray-500">هیچ واحدی یافت نشد.</p>
        @endif
    </x-card>

    <x-modal wire:model="modal" title="{{ $editing ? 'ویرایش واحد' : 'ایجاد واحد' }}" separator persistent>
        <x-form wire:submit="save" class="space-y-4">
            <x-input label="نام" wire:model="name" required class="w-full input-bordered bg-white text-black" />
            <x-select label="نوع" wire:model.live="type_id" :options="$types" option-value="value" option-label="label" required class="w-full select-bordered bg-white text-black" placeholder="انتخاب نوع" />
            <x-select label="بالادستی" wire:model="parent_id" :options="$parents" option-value="value" option-label="label" class="w-full select-bordered bg-white text-black" placeholder="انتخاب بالادستی" />
            <x-select label="موقعیت" wire:model="location_id" :options="$locations" option-value="value" option-label="label" class="w-full select-bordered bg-white text-black" placeholder="انتخاب موقعیت" />
            <div class="flex justify-end gap-2">
                <x-button label="{{ $editing ? 'بروزرسانی' : 'ذخیره' }}" type="submit" icon="o-check" class="btn-primary" />
                <x-button label="لغو" wire:click="$set('modal', false)" icon="o-x-mark" class="btn-outline" />
            </div>
        </x-form>
    </x-modal>
</div>