<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\SyncRules
 *
 * @property int $site_id
 * @property string $title
 * @property string $description
 * @property string $price
 * @property string $in_stock
 * @property string $in_stock_value
 * @property string $images
 * @property string|null $variants
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SyncRules newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SyncRules newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SyncRules query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SyncRules whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SyncRules whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SyncRules whereInStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SyncRules whereInStockValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SyncRules wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SyncRules whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SyncRules whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SyncRules whereVariants($value)
 */
	class SyncRules extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Product
 *
 * @property int $id
 * @property int $site_id
 * @property string $title
 * @property string|null $description
 * @property string $url
 * @property string $category
 * @property string $status
 * @property string|null $synced_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductImage[] $productImages
 * @property-read \App\Models\Site $site
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Variant[] $variants
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereSyncedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product withoutTrashed()
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductImage
 *
 * @property int $id
 * @property int $product_id
 * @property string $url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductImage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductImage whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductImage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductImage whereUrl($value)
 */
	class ProductImage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Variant
 *
 * @property int $id
 * @property int $product_id
 * @property string $name
 * @property float $price
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Variant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Variant newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Variant onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Variant query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Variant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Variant whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Variant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Variant whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Variant wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Variant whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Variant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Variant withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Variant withoutTrashed()
 */
	class Variant extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Site
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $url
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $Product
 * @property-read \App\Models\SyncRules $SyncRules
 * @property-read \App\User $User
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Site newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Site newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Site onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Site query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Site whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Site whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Site whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Site whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Site whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Site whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Site whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Site whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Site withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Site withoutTrashed()
 */
	class Site extends \Eloquent {}
}

