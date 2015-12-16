<?php
/*  author: Arnold Buntsma
    10/12/2015
    winkelwagen
*/
/**
 *
 */
class ShoppingCart {

    private $errors = array();

    public function addItem($id){
      if (!$id) {
        $this->addError("De producten hebben een unieke waarde nodig");
        return false;
      }
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
        //$item->items[$id]=array('item' => $item, 'qty' => 1);
      }
      return true;
    }

    public function updateQuantity($id, $qty){
      //items verwijderen
      $productToUpdate = Database::start()->get('*', 'shoppingcart', array(
        array('product_id', '=', $id),
        array('user_id', '=', $_SESSION['_user']['id'])
      ));
      if ($qty === 0){
        $this->deleteItem($id);
      } else {
        Database::start()->update('shoppingcart', array(
          'amount' => $qty
        ), array(array('product_id','=', $id), array('user_id', '=', $_SESSION['_user']['id'])));
      }
    }

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

    public function count(){
      return count($this->items);
    }

    public function getErrors() {
		return $this->errors;
	}

	private function addError($error) {
		if (is_string($error)) {
			array_push($this->errors, $error);
		}
	}
}

?>
