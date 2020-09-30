<?php
namespace App\Model\Sql;

use Illuminate\Database\Eloquent\Model;

/**
 * Model for Organization Contact Detail Table
 *
 * @license         <add Licence here>
 * @link            https://github.com/riyazpatwegar
 * @author          Riyaz Patwegar
 * @since           Sep 29, 2020
 * @copyright       2020 <https://github.com/riyazpatwegar>
 * @version         1.0
 */
class OrganizationContact extends Model
{
    
    /** @var string Table Name */
    protected $table = 'tbl_contact';

    /** @var bool Enable/Disable Timestamp */
    public $timestamps = false;
}