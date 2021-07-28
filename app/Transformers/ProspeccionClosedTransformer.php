<?php

use League\Fractal\TransformerAbstract;

class ProspeccionClosedTransformer extends TransformerAbstract
{

  /**
   * Turn this item object into a generic array
   *
   * @return array
   */
  public function transform($prospeccion)
  {
    return [
      'prospeccion_id'     => $prospeccion->id,
      'prospeccion_name'   => $prospeccion->name
    ];
  }

}
?>
