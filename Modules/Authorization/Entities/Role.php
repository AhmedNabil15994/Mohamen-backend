<?php

namespace Modules\Authorization\Entities;

use IlluminateAgnostic\Str\Support\Str;
use Modules\Core\Traits\HasTranslations;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use LogsActivity;
    use HasTranslations;
    public $translatable = ['display_name'];
    protected static $logAttributes = ['name'];
    protected static $logOnlyDirty = true;



  
}
