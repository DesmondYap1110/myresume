<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory, HasTranslations;

    const status_active = 1;
    const status_block  = 0;

    protected $table = 'service';
    protected $guarded = [];

    /** The icon definition from config/service_icons.php, with a safe fallback. */
    public function iconSet(): array
    {
        $icons = (array) config('service_icons', []);

        $icon = $icons[$this->icon] ?? reset($icons) ?: [];

        return $icon + [
            'label' => '',
            'fa' => 'fas fa-star',       // admin (Font Awesome 5)
            'fa4' => 'fa fa-star',       // Template 1 website (Font Awesome 4)
            'ti' => 'ti-star',           // Template 2 (Themify)
            'svg' => 'M12 3l2.6 7.4L22 11l-7.4 2.6L12 21l-2.6-7.4L2 11l7.4-2.6z', // Template 3
        ];
    }

    static function getServiceByUserid($id)
    {
        $query = self::where('user_id', $id)->where('status', self::status_active);
        return $query->orderBy('sort_order')->orderBy('id')->get();
    }

    static function getServiceById($user_id, $id)
    {
        $query = self::where('user_id', $user_id)->where('id', $id)->where('status', self::status_active);
        return $query->first();
    }
}
