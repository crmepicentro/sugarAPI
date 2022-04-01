<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpportunitiesContacts extends Model
{
    use HasFactory;
    protected $connection = 'sugar_dev';
    protected $table = 'opportunities_contacts';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id', 'contact_id', 'opportunity_id', 'contact_role', 'date_modified','deleted'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->setConnection(get_connection());
    }
}
