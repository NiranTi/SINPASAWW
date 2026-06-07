<?php
// ── app/Models/Konten.php ──────────────────────────────────────────────────
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Konten extends Model
{
    /* Kolom updated_at: tambahkan via migration:
       php artisan make:migration add_updated_at_to_konten_table --table=konten
       → $table->timestamp('updated_at')->nullable()->after('created_at'); */

    protected $table = 'konten';
    protected $primaryKey = 'konten_id';
    public    $incrementing = false;
    protected $keyType      = 'string';

    protected $fillable = [
        'konten_id',
        'user_id',
        'judul',
        'deskripsi',
        'kategori',
        'img_url',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /* ── Auto-generate konten_id saat creating ── */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Konten $model) {
            if (empty($model->konten_id)) {
                $model->konten_id = static::generateId();
            }
        });
    }

    private static function generateId(): string
    {
        $last = static::orderByDesc('konten_id')->value('konten_id');
        $num  = $last ? (intval(ltrim(substr($last, 1), '0') ?: 0) + 1) : 1;
        return 'K' . str_pad($num, 3, '0', STR_PAD_LEFT);
    }

    /* ── Relasi ── */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /* ── Scopes ── */
    public function scopeAktif($query)    { return $query->where('status', 'aktif'); }
    public function scopeNonaktif($query) { return $query->where('status', 'nonaktif'); }

    /* ── Accessor: URL gambar lengkap ── */
    public function getImgFullUrlAttribute(): string
    {
        if (!$this->img_url) return '';
        if (str_starts_with($this->img_url, 'http')) return $this->img_url;
        return asset('storage/' . $this->img_url);
    }
}
