<?php 

class Ordersystem {

    private $order_id=0;
   
    public function __construct($db){
        $this->db = $db;
        $this->userID = $_SESSION['_user']['id'];
    }

    public function placeOrder(){
        // Maak een nieuwe order aan
        $this->setOrderId();
        
        // Verkrijg alle producten die in het winkelmandje staan
        $Shopping = $this->db->start()->get('*','shoppingcart', array(array('user_id', '=', $this->userID)))->results();
        foreach($Shopping as $products => $val){
            // Plaats de producten naar oder_line
            $this->db->start()->insert('order_line', array(
                'order_id' => $this->order_id,
                'product_id' => $val->product_id,
                'amount' => $val->amount
             ));
            
            // Verwijder uit shoppingcart
            $this->db->start()->delete('shoppingcart', array(array('user_id', '=', $this->userID), array('product_id', '=', $val->product_id)));
        }
        
     }
     
     public function getOrderByID($id){
        if(!empty($id)){
            $data = $this->db->start()->get('*','order', array(array('id', '=', $id)))->results();
            
            foreach($data as $key => $product) {
                //$productData = $this->db->start()->get('*','product', array(array('id', '=', $product->product_id)))->first();
                $producten = $this->db->start()->get('*','order_line', array(array('order_id', '=', $product->id)))->results();
                echo "<table class='cms'>";
                echo "<td width='50%' style='vertical-align:top'>
                          <table class='cms page'>
                            <tr>
                                <td width='30%'><b>Ordernummer:</b></td>
                                <td width='70%'>".$product->id."</td>
                            </tr>
                            <tr>
                                <td width='30%'><b>Datum:</b></td>
                                <td width='70%'>".$product->created_at."</td>
                            </tr>
                          </table>
                          <br/>";
                    $subtotaal = 0;
                foreach($producten as $ky => $orderline){
                    $productData = $this->db->start()->get('*','product', array(array('id', '=', $orderline->product_id)))->first();
                    $subtotaal = ($productData->price * $orderline->amount) + $subtotaal;
                    echo "
                          <table class='cms page' width='100%'>
                            <tr>
                                <td width='30%'><b>Product:</b></td>
                                <td width='70%'>".$productData->name."</td>
                            </tr>
                            <tr>
                                <td width='30%'><b>Aantal:</b></td>
                                <td width='70%'>".$orderline->amount."</td>
                            </tr>
                            <tr>
                                <td width='30%'><b>Prijs totaal:</b></td>
                                <td width='70%'>&euro;".number_format((($productData->price * $orderline->amount)), 2, ',', '.')."</td>
                            </tr>
                            <tr>
                                <td width='30%'><b>Prijs per stuk:</b></td>
                                <td width='70%'>&euro;".number_format(($productData->price), 2, ',', '.')."</td>
                            </tr>
                          </table>
                          <br/>
                          
                      ";
                }
                $btw = $product->tax / 100 * 1;
                $btw = $subtotaal * $btw;
                
                
                echo "<table class='cms page' width='100%'>
                            <tr>
                                <td width='30%'><b>Subtotaal:</b></td>
                                <td width='70%'>&euro;".number_format(($subtotaal), 2, ',', '.')."</td>
                            </tr>
                            <tr>
                                <td width='30%'><b>Btw:</b></td>
                                
                                <td width='70%'>&euro;".number_format($btw, 2, ',', '.')."</td>
                            </tr>
                            <tr>
                                <td width='30%' style='background-color:#5F5F5F; color:white;'><b>Totaal:</b></td>
                                <td width='70%' style='background-color:#5F5F5F; color:white;'>&euro;".number_format(($subtotaal + $btw), 2, ',', '.')."</td>
                            </tr>
                            
                          </table>";
                
                $customerData = $this->db->start()->get('*','customer', array(array('user_id', '=', $product->user_id)))->first();
                $userData = $this->db->start()->get('*','user', array(array('id', '=', $product->user_id)))->first();
                echo "</td>
                      <td style='vertical-align:top'>
                        <table class='cms page'>
                            <tr>
                                <td width='30%'><b>Klant nummer:</b></td>
                                <td width='70%'>".$product->user_id."</td>
                            </tr>
                            <tr>
                                <td width='30%'><b>Klant naam:</b></td>
                                <td width='70%'>".$userData->firstname." ".$userData->lastname."</td>
                            </tr>
                            <tr>
                                <td width='30%'><b>E-Mail:</b></td>
                                <td width='70%'>".$userData->email."</td>
                            </tr>
                        </table>
                      </td>";
                echo "</table>";
            }
            
        }else{
            return 'none';
        }
     }
    
    public function changeOrderstatus($orderid, $status){
        //var_dump($status);
        
        $checkOrders = $this->db->start()->get('*','order', array(array('id', '=', $orderid)))->first();
        if(!empty($checkOrders) OR $checkOrders != ''){
            
            $this->db->start()->update('order', array('complete' => $status), array(array('id', '=', $orderid)));
            
            switch($status){
                case 0: $st =  'Deze order is op niet voldaan gezet!'; break;
                case 1: $st =  'Deze order is op  voldaan gezet!'; break;
            }
            $this->setMSG($st);
        }else{
            $this->setError('Deze order bestaat niet!');
        }
    }
    
    private function setOrderId() {
        $checkOrders = $this->db->start()->get('*','order', array(array('user_id', '=', $this->userID)))->first();
        if(empty($checkOrders) OR $checkOrders == ''){
            // Er is nog geen order aangemaakt voor de klant
            $this->db->start()->insert('order', array(
                'user_id' => $_SESSION['_user']['id']
            ));
        }
        
        // Haal het ID op
        $checkOrders = $this->db->start()->get('*','order', array(array('user_id', '=', $this->userID)))->first();
        $this->order_id = $checkOrders->id;
            
    }

    public function getShoppingcart() {
        $products = Database::start()->get('*', 'shoppingcart', array(
                array('user_id', '=', $_SESSION['_user']['id'])
            ))->results();

        foreach($products as $key => $product) {          
            $this->setOrderLine($this->order_id, $product->product_id, $product->amount);
        }
    }

    private function setOrderLine($order_id, $product_id, $amount) {


        $result = Database::start()->insert('order_line', array(
                'order_id' => $order_id,
                'amount' => $amount,
                'product_id' => $product_id,
            ));
    }
    
    private function setError($error){
        $this->error = $error;
    }
    
    public function getError(){
        return $this->error;
        unset($this->error);
    }
    
    public function setMSG($msg){
        $this->msg = $msg;
    }
    
    public function getMSG(){
        return $this->msg;
    }
    
    /*public function myOrders() {
        // return order
    }*/
}