<?php
class ShoppingCart {

    private $errors = array();

    /**
    *Arnold Buntsma (16-12-2015)
    *Usage:
    *$shoppingcart->addItem($itemID)
    */
    public function addItem($id){
      $product = Database::start()->get('*', 'shoppingcart', array(
        array('product_id', '=', $id),
        array('user_id', '=', $_SESSION['_user']['id'])
      ));
      if ($product->count() > 0){
        Database::start()->update('shoppingcart', array(
          'amount' => ($product->first()->amount + 1)
        ), array(array('product_id','=', $id), array('user_id', '=', $_SESSION['_user']['id'])));
      }else{
        Database::start()->insert('shoppingcart', array(
          'product_id' => $id,
          'user_id' => $_SESSION['_user']['id'],
          'amount' => 1
        ));
      }
      return true;
    }

    /**
    *Arnold Buntsma (16-12-2015)
    *Usage:
    *$shoppingcart->updateItem($itemID, $quantity)
    */
    public function updateQuantity($id, $qty){
      $productToUpdate = Database::start()->get('*', 'shoppingcart', array(
        array('product_id', '=', $id),
        array('amount', '=', $qty),
        array('user_id', '=', $_SESSION['_user']['id'])
      ));
      if ($qty == 0){
        $this->deleteItem($id);
      }
      // elseif ($qty < 0) {
      //   echo ('<p class="error"><i>De hoeveelheid mag niet minder dan 0 zijn</i></p>');
      // }
      else {
        Database::start()->update('shoppingcart', array(
          'amount' => $qty),
           array(
             array('product_id','=', $id),
              array('user_id', '=', $_SESSION['_user']['id'])));
      }
    }

    /**
    *Arnold Buntsma (16-12-2015)
    *Usage:
    *$shoppingcart->deleteItem($itemID)
    *Note: hiermee verwijder je het product uit je winkelwagen, ongeacht de hoeveelheid
    */
    public function deleteItem($id){
      $product = Database::start()->get('*', 'shoppingcart', array(
        array('product_id', '=', $id),
        array('user_id', '=', $_SESSION['_user']['id'])
      ));
      if ($product->count() > 0){
        Database::start()->delete('shoppingcart', array(
          array('product_id', '=', $id),
          array('user_id', '=', $_SESSION['_user']['id'])
        ));
      }
    }

    /**
    *Arnold Buntsma (16-12-2015)
    *Usage:
    *$shoppingcart->getShoppingcart()
    */
    public function getShoppingcart(){
      	return Database::start()->get('*', 'shoppingcart', array(
        array('user_id', '=', $_SESSION['_user']['id'])
      ))->results();
    }

    /**
    *Arnold Buntsma (16-12-2015)
    *Usage:
    *$shoppingcart->getproduct($itemID)
    */
    public function getProduct($id) {
      return Database::start()->get('*', 'product', array(
        array('id', '=', $id)
      ))->first();
    }

    public function getTotalPrice(){
      foreach($this->getShoppingcart() as $item){
        $product = $this->getProduct($item->product_id);
        $price = $product->price;
        $qty = $item->amount;
        $subtotal = ($product->price * $qty);
        
      }
    }

}

?>
