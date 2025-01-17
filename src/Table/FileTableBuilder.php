<?php

namespace Anomaly\FilesFieldType\Table;

use Anomaly\FilesModule\File\FileModel;
use Anomaly\FilesModule\Folder\Command\GetFolder;
use Anomaly\PreferencesModule\Preference\Contract\PreferenceRepositoryInterface;
use Anomaly\Streams\Platform\Ui\Table\Table;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class FileTableBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class FileTableBuilder extends TableBuilder
{
    public function __construct(PreferenceRepositoryInterface $preferences, Table $table)
    {
        parent::__construct($table);
        $default_order_by = $preferences->value('anomaly.field_type.files::default_order_by', 'updated_at');
        $default_order_direction = $preferences->value('anomaly.field_type.files::default_order_direction', 'desc');

        $this->options['order_by'] = [$default_order_by => $default_order_direction];
    }

    /**
     * Field configuration.
     *
     * @var array
     */
    protected $config = [];

    /**
     * The ajax flag.
     *
     * @var bool
     */
    protected $ajax = true;

    /**
     * The table model.
     *
     * @var string
     */
    protected $model = FileModel::class;

    /**
     * The table columns.
     *
     * @var array
     */
    protected $columns = [
        'entry.preview' => [
            'heading' => 'anomaly.module.files::field.preview.name',
        ],
        'name'          => [
            'sort_column' => 'name',
            'wrapper'     => '
                    <strong>{value.file}</strong>
                    <br>
                    <small class="text-muted">{value.disk}://{value.folder}/{value.file}</small>
                    <br>
                    <span><span class="tag {value.size_tag_type} tag-sm">{value.readable_file_size}</span> <span class="tag tag-default tag-sm text-gray-dark">{value.mime_type}</span> {value.size} {value.keywords}</span>',
            'value'       => [
                'file'     => 'entry.name',
                'mime_type'     => 'entry.mime_type',
                'folder'   => 'entry.folder.slug',
                'keywords' => 'entry.keywords.labels|join',
                'disk'     => 'entry.folder.disk.slug',
                'size'     => 'entry.size_label',
                'size_tag_type' => 'entry.size.value < 150000 ? "tag-info" : entry.size.value < 350000 ? "tag-warning" : "tag-danger"',
                'readable_file_size' => 'entry.readable_size',
            ],
        ],
        'folder',
        'updated_at'          => [
            'sort_column' => 'updated_at',
            'wrapper'     => '{value.updated_at_human}
                              <br>
                              <small class="text-muted">{value.updated_at}</small>',
            'value'       => [
                'updated_at' => 'entry.updated_at.format("M jS, Y, H:i")',
                'updated_at_human' => 'entry.updated_at.diffForHumans()'
            ],
        ],
    ];

    /**
     * The table buttons.
     *
     * @var array
     */
    protected $buttons = [
        'add' => [
            'data-file' => 'entry.id',
        ],
    ];

    /**
     * The table options.
     *
     * @var array
     */
    protected $options = [
        'enable_views' => false,
        'title'        => 'anomaly.field_type.files::message.choose_files',
    ];

    /**
     * Add all entries.
     *
     * @var array
     */
    protected $actions = [
        'add_selected',
    ];

    /**
     * Fired when query starts building.
     *
     * @param Builder $query
     */
    public function onQuerying(Builder $query)
    {
        if ($folders = array_get($this->getConfig(), 'folders')) {
            $query->whereIn(
                'folder_id',
                array_filter(
                    array_map(
                        function ($folder) {

                            if (is_numeric($folder)) {
                                return $folder;
                            }

                            if ($folder = $this->dispatch(new GetFolder($folder))) {
                                return $folder->getId();
                            }

                            return null;
                        },
                        $folders
                    )
                )
            );
        }

        if ($allowed = array_get($this->getConfig(), 'allowed_types')) {
            $query->whereIn('extension', $allowed);
        }
    }

    /**
     * Get the config.
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set the config.
     *
     * @param  array $config
     * @return $this
     */
    public function setConfig(array $config = [])
    {
        $this->config = $config;

        return $this;
    }
}
