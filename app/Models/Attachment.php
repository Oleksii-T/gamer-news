<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Yajra\DataTables\DataTables;
use App\Traits\HasTranslations;

class Attachment extends Model
{
    use HasFactory, HasTranslations;

    /**
     * @var array
     */
	protected $fillable = [
        'name',
        'group',
        'original_name',
        'type',
        'size',
        'attachmentable_id',
        'attachmentable_id_type'
    ];

    protected $appends = self::TRANSLATABLES + [
        'url'
    ];

    const TRANSLATABLES = [
        'alt',
        'title'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            $model->purgeTranslations();
            $disk = self::disk($model->type);
            Storage::disk($disk)->delete($model->name);
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function attachmentable()
    {
        return $this->morphTo();
    }

    /**
     * @return string
     */
    public function getSize()
    {
        if ($this->size > 1000000) {
            return number_format($this->size / 1000000, 2) . ' MB';
        }
        if ($this->size > 1000) {
            return number_format($this->size / 1000, 2) . ' kB';
        }

        return $this->size . ' B';
    }

    public function url(): Attribute
    {
        return new Attribute(
            get: fn ($value) => Storage::disk(self::disk($this->type))->url($this->name),
        );
    }

    public function alt(): Attribute
    {
        return new Attribute(
            get: fn () => $this->translated('alt')
        );
    }

    public function title(): Attribute
    {
        return new Attribute(
            get: fn () => $this->translated('title')
        );
    }

    public static function disk($type)
    {
        return match ($type) {
            'video' => 'avideos',
            'image' => 'aimages',
            'document' => 'adocuments',
            default => 'attachments',
        };
    }

    public static function dataTable($query)
    {
        return DataTables::of($query)
            ->editColumn('size', function ($model) {
                return $model->getSize() . " ($model->size)";
            })
            ->editColumn('created_at', function ($model) {
                return $model->created_at->format(env('ADMIN_DATETIME_FORMAT'));
            })
            ->addColumn('action', function ($model) {
                return view('components.admin.actions', [
                    'model' => $model,
                    'name' => 'attachments',
                    'actions' => ['edit']
                ])->render();
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
