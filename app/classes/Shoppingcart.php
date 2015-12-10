<?php
/*  author: Arnold Buntsma
    10/12/2015
    winkelwagen
*/
/**
 *
 */
class ShoppingCart implements Iterator, Countable {

    private $items = array();

    public function isEmpty(){
      return (empty($this->items));
    }

    public function addItem(Item $item){
      $id = $item->getId();
      //voor als er geen uniek ID is geef een exeption
      if (!id)throw new Exception("De producten hebben een unieke waarde nodig");
      //items toevoegen aan de wagen en als het product al in de
      if (isset($this->items[$id])){
        $this->updateItem($item, $this->items[$item]['qty'] +1);
      }else{
        $item->items[$id]=array('item' => $item, 'qty' => 1);
      }
    }

    public function updateItem(Item $item, $qty){
      $id = $item->getId();
      //items verwijderen
      if ($qty === 0){
        $this->deleteItem($item);
      } else if ( ($qty > 0) && ($qty != $this->items[$id]['qty'])){
        $this->items[$id]['qty'] = $qty;
      }
    }

    public function deleteItem(Item $item){
      $id = $item->getId();
      if (isset($this->items[$id])){
        unset($this->items[$id]);
      }
    }

    public function count(){
      return count($this->items);
    }
}

?>
