<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Question extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
?>
