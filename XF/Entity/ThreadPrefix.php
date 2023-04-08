<?php

namespace Jaysc\Prefix\XF\Entity;

use XF\Mvc\Entity\Entity;

class ThreadPrefix extends XFCP_ThreadPrefix
{
    public function getTotalPrefixes(Entity $entity)
    {
        return $this->finder('XF:Thread')
                    ->where([
                        'node_id' => $entity->getEntityId(), 
                        'prefix_id' => $this->prefix_id
                    ])
                    ->total();
    }
}