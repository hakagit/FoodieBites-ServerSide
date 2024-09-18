<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * 
 *
 * @property int $inventory_id
 * @property int $supplier_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|InventorySupplier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InventorySupplier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InventorySupplier query()
 * @method static \Illuminate\Database\Eloquent\Builder|InventorySupplier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventorySupplier whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventorySupplier whereInventoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventorySupplier whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventorySupplier whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InventorySupplier extends Pivot
{
    protected $table = 'inventory_supplier';

    // Add any additional properties or methods if needed
}
