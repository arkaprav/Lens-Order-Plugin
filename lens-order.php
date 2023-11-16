<?php
/*
Plugin Name: Lens Order
Plugin URI: https://github.com/arkaprav/Lens-Order-Plugin.git
Description: Creatng Order for lenses and Frames
Version: 1.0.0
Requires at least: 6.2
Requires PHP: 7.4
Author: Arkaprava
Author URI: https://github.com/arkaprav/
Text Domain: lensorder
*/
function wpdocs_register_my_custom_menu_page(){
	add_menu_page( 
		__( 'Lens Order', 'lensorder' ),
		'Lens Order',
		'manage_options',
		'lensorder',
		'len_order_menu_page',
		'dashicons-admin-tools',
		6
	); 
}
add_action( 'admin_menu', 'wpdocs_register_my_custom_menu_page' );

function len_order_menu_page(){
    $query = new WC_Product_Query();
    $products_query = $query->get_products();
    $lenses = array();
    $frames = array();
    foreach ( $products_query as $product ) {
        $p = $product->get_data();
        if($p['stock_quantity'] > 0){
            if($p['category_ids'][0] === 17){
                $lenses[] = $p;
            }
            else{
                $frames[] = $p;
            }
        }
    }
    $right_sph = 0;
    $left_sph = 0;
    $right_cyl = 0;
    $left_cyl = 0;
    $right_axis = 0;
    $left_axis = 0;
    $right_va = 0;
    $left_va = 0;
    $right_near_add = 0;
    $left_near_add = 0;
    $right_nv = 0;
    $left_nv = 0;
    if(isset($_POST['right_sph'])){
        $right_sph = $_POST['right_sph'];
    }
    if(isset($_POST['left_sph'])){
        $left_sph = $_POST['left_sph'];
    }
    if(isset($_POST['right_cyl'])){
        $right_cyl = $_POST['right_cyl'];
    }
    if(isset($_POST['left_cyl'])){
        $left_cyl = $_POST['left_cyl'];
    }
    if(isset($_POST['right_axis'])){
        $right_axis = $_POST['right_axis'];
    }
    if(isset($_POST['left_axis'])){
        $left_axis = $_POST['left_axis'];
    }
    if(isset($_POST['right_va'])){
        $right_va = $_POST['right_va'];
    }
    if(isset($_POST['left_va'])){
        $left_va = $_POST['left_va'];
    }
    if(isset($_POST['right_near_add'])){
        $right_near_add = $_POST['right_near_add'];
    }
    if(isset($_POST['left_near_add'])){
        $left_near_add = $_POST['left_near_add'];
    }
    if(isset($_POST['right_nv'])){
        $right_nv = $_POST['right_nv'];
    }
    if(isset($_POST['left_nv'])){
        $left_nv = $_POST['left_nv'];
    }
    $powers = "
        <table>
            <thead>
                <tr>
                    <th>
                        Eye
                    </th>
                    <th>
                        Sph
                    </th>
                    <th>
                        Cyl
                    </th>
                    <th>
                        Axis
                    </th>
                    <th>
                        VA
                    </th>
                    <th>
                        Near ADD
                    </th>
                    <th>
                        NV
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        Right
                    </td>
                    <td>
                        ".$right_sph."
                    </td>
                    <td>
                        ".$right_cyl."
                    </td>
                    <td>
                        ".$right_axis."
                    </td>
                    <td>
                        ".$right_va."
                    </td>
                    <td>
                        ".$right_near_add."
                    </td>
                    <td>
                        ".$right_nv."
                    </td>
                </tr>
                <tr>
                    <td>
                        Left
                    </td>
                    <td>
                        ".$left_sph."
                    </td>
                    <td>
                        ".$left_cyl."
                    </td>
                    <td>
                        ".$left_axis."
                    </td>
                    <td>
                        ".$left_va."
                    </td>
                    <td>
                        ".$left_near_add."
                    </td>
                    <td>
                        ".$left_nv."
                    </td>
                </tr>
            </tbody>
        </table>
    ";
    $lens_type = "";
    $lens_side = "";
    $lens_price = 0;
    if(isset($_POST['lens-type'])){
        $lens_type = $_POST['lens-type'];
    }
    if(isset($_POST['lens-side'])){
        $lens_side = $_POST['lens-side'];
    }
    if(isset($_POST['lens-price'])){
        $lens_price = $_POST['lens-price'];
    }
    $lens = "
        <table>
            <thead>
                <tr>
                    <th>
                        Lens Type
                    </th>
                    <th>
                        Lens Side
                    </th>
                    <th>
                        Lens Price
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        ".$lens_type."
                    </td>
                    <td>
                        ".$lens_side."
                    </td>
                    <td>
                        ".$lens_price."
                    </td>
                </tr>
            </tbody>
        </table>
    ";
    $frame_id = 0;
    $frame_type = '';
    $frame_price = 0;
    if(isset($_POST['frame-name'])){
        if($_POST['frame-name'] != "null"){
            $frame_id = $_POST['frame-name'];
        }
    }
    if(isset($_POST['frame-type'])){
        $frame_type = $_POST['frame-type'];
    }
    if(isset($_POST['frame-price'])){
        if($frame_id != 0){
            $frame_price = $_POST['frame-price'];
        }
    }
    $frame = "
        <table>
            <thead>
                <tr>
                    <th>
                        Frame Type
                    </th>
                    <th>
                        Frame Price
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        ".$frame_type."
                    </td>
                    <td>
                        ".$frame_price."
                    </td>
                </tr>
            </tbody>
        </table>
    ";
    $address = array();
    $lens_prod = array();
    $lens_id = 0;
    $gst = 0;
    $discount = 0;
    if(isset($_POST['customer-name'])){
        $address['first_name'] = $_POST['customer-name'];
    }
    if(isset($_POST['customer-email'])){
        $address['email'] = $_POST['customer-email'];
    }
    if(isset($_POST['customer-phone'])){
        $address['phone'] = $_POST['customer-phone'];
    }
    
    if(isset($_POST['lens-name'])){
        $lens_id = floatval($_POST['lens-name']);
    }
    if(isset($_POST['gst'])){
        $gst = floatval($_POST['gst']);
    }
    if(isset($_POST['discount'])){
        $discount = floatval($_POST['discount']);
    }
    if(isset($_POST['customer-address'])){
        $address['address_1'] = $_POST['customer-address'];
        $total = floatval($lens_price)+floatval($frame_price);
        $gst_total = $total*(floatval($gst)/100);
        $total += $gst_total;
        $discount_total = $total*(floatval($discount)/100);
        $total -= $discount_total;
        $order = wc_create_order();
        $order -> add_product(wc_get_product( $lens_id ), 1, [
            'subtotal' => floatval($lens_price),
            'total' => floatval($lens_price)
        ]);
        foreach ( $order->get_items() as $item_key => $item ) {
            if(intval($item['product_id']) === intval($lens_id)){
                $item->add_meta_data( 'powers', $powers, true );
                $item->add_meta_data( 'lens', $lens, true );
            }
        }
        echo $frame_id;
        if($frame_id != 0){
            $order -> add_product(wc_get_product( $frame_id ), 1, [
                'subtotal' => floatval($frame_price),
                'total' => floatval($frame_price)
            ]);
            foreach ( $order->get_items() as $item_key => $item ) {
                if(intval($item['product_id']) === intval($frame_id)){
                    $item->add_meta_data( 'frames', $frame, true );
                }
            }
        }

        $item_fee = new WC_Order_Item_Fee();
        
        $item_fee->set_name( "GST" ); // Generic fee name
        $item_fee->set_amount( $gst_total ); // Fee amount
        $item_fee->set_tax_class( '' ); // default for ''
        $item_fee->set_tax_status( 'none' ); // or 'none'
        $item_fee->set_total( $gst_total ); // Fee amount

        $order -> add_item($item_fee);

        if($discount > 0){
            $item_fee = new WC_Order_Item_Fee();
        
            $item_fee->set_name( "Discount" ); // Generic fee name
            $item_fee->set_amount( -$discount_total ); // Fee amount
            $item_fee->set_tax_class( '' ); // default for ''
            $item_fee->set_tax_status( 'none' ); // or 'none'
            $item_fee->set_total( -$discount_total ); // Fee amount

            $order -> add_item($item_fee);
        }

        $order -> set_status("completed");

        $order -> set_address($address, 'billing');

        $order -> set_address($address, 'shipping');

        $order -> set_total($total);

        $order -> save();
    }    
	?>
    <form method="post">
        <h1><?php _e('Lens Order', 'lensorder') ?></h1>
        <table>
            <thead>
                <tr>
                    <th>
                        Eye
                    </th>
                    <th>
                        Sph
                    </th>
                    <th>
                        Cyl
                    </th>
                    <th>
                        Axis
                    </th>
                    <th>
                        VA
                    </th>
                    <th>
                        Near ADD
                    </th>
                    <th>
                        NV
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        Right
                    </td>
                    <td>
                        <select name='right_sph' id='right_sph'>
                            <?php for ($i=-10; $i < 10; $i+=0.25) { 
                                ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php
                            } ?>
                        </select>
                    </td>
                    <td>
                        <select name='right_cyl' id='right_cyl'>
                            <?php for ($i=-10; $i < 10; $i+=0.25) { 
                                ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php
                            } ?>
                        </select>
                    </td>
                    <td>
                        <select name='right_axis' id='right_axis'>
                            <?php for ($i=0; $i < 100; $i++) { 
                                ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php
                            } ?>
                        </select>
                    </td>
                    <td>
                        <select name='right_va' id='right_va'>
                            <option value="6/6">6/6</option>
                            <option value="6/9">6/9</option>
                            <option value="6/12">6/12</option>
                            <option value="6/18">6/18</option>
                            <option value="6/24">6/24</option>
                            <option value="6/36">6/36</option>
                        </select>
                    </td>
                    <td>
                        <select name='right_near_add' id='right_near_add'>
                            <?php for ($i=0; $i < 10; $i+=0.25) { 
                                ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php
                            } ?>
                        </select>
                    </td>
                    <td>
                        <select name='right_nv' id='right_nv'>
                            <option value="N-6">N-6</option>
                            <option value="N-8">N-8</option>
                            <option value="N-10">N-10</option>
                            <option value="N-12">N-12</option>
                            <option value="N-18">N-18</option>
                            <option value="N-24">N-24</option>
                            <option value="N-36">N-36</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        Left
                    </td>
                    <td>
                        <select name='left_sph' id='left_sph'>
                            <?php for ($i=-10; $i < 10; $i+=0.25) { 
                                ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php
                            } ?>
                        </select>
                    </td>
                    <td>
                        <select name='left_cyl' id='left_cyl'>
                            <?php for ($i=-10; $i < 10; $i+=0.25) { 
                                ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php
                            } ?>
                        </select>
                    </td>
                    <td>
                        <select name='left_axis' id='left_axis'>
                            <?php for ($i=0; $i < 100; $i++) { 
                                ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php
                            } ?>
                        </select>
                    </td>
                    <td>
                        <select name='left_va' id='left_va'>
                            <option value="6/6">6/6</option>
                            <option value="6/9">6/9</option>
                            <option value="6/12">6/12</option>
                            <option value="6/18">6/18</option>
                            <option value="6/24">6/24</option>
                            <option value="6/36">6/36</option>
                        </select>
                    </td>
                    <td>
                        <select name='left_near_add' id='left_near_add'>
                            <?php for ($i=0; $i < 10; $i+=0.25) { 
                                ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php
                            } ?>
                        </select>
                    </td>
                    <td>
                        <select name='left_nv' id='left_nv'>
                            <option value="N-6">N-6</option>
                            <option value="N-8">N-8</option>
                            <option value="N-10">N-10</option>
                            <option value="N-12">N-12</option>
                            <option value="N-18">N-18</option>
                            <option value="N-24">N-24</option>
                            <option value="N-36">N-36</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="lens-section" style="display: flex; gap: 20px;">
            <h3>Lens</h3>
            <select name="lens-name" id="lens-name">
                <?php
                    foreach ($lenses as $lens) {
                        ?>
                            <option value=<?php echo $lens['id']?>><?php echo $lens['name']?></option>
                        <?php
                    }
                ?>
            </select>

            <h3>Lens Type</h3>
            <select name="lens-type" id="lens-type">
                <option value="distance">Distance</option>
                <option value="near">Near</option>
                <option value="bifocal">BiFocal</option>
            </select>
            
            <h3>Lens Side</h3>
            <select name="lens-side" id="lens-side">
                <option value="right">Right</option>
                <option value="left">Left</option>
                <option value="both">Both</option>
            </select>
            <h3>Lens Price</h3>
            <input type="number"name="lens-price" id="lens-price" />
        </div>
        <div class="frame-section" style="display: flex; gap: 20px;">
            <h3>Frame Brand</h3>
            <select name="frame-name" id="frame-name">
                <option value="null">None</option>
                <?php
                    foreach($frames as $frame) {
                        ?>
                            <option value=<?php echo $frame['id']?>><?php echo $frame['name']?></option>
                        <?php
                    }
                ?>
            </select>

            <h3>Frame Type</h3>
            <select name="frame-type" id="frame-type">
                <option value="rimless">Rim Less</option>
                <option value="fullframe">Full Frame</option>
                <option value="supra">Supra</option>
                <option value="polyc">Polyc</option>
                <option value="goggle">Goggle</option>
                <option value="indian">Indian</option>
                <option value="sheet">Sheet</option>
            </select>

            <h3>Frame Price</h3>
            <input type="number"name="frame-price" id="frame-price" required/>
        </div>

        <div style="display: flex;">
            <h3>GST(%)</h3>
            <input type="number" name="gst" id="gst" required/>
        </div>
        
        <div style="display: flex;">
            <h3>Discount(%)</h3>
            <input type="number" name="discount" id="discount" />
        </div>

        <div style="display: flex;">
            <h3>Remarks</h3>
            <textarea name="remarks" id="remarks"></textarea>
        </div>

        <div style="display: flex;">
            <h3>Customer Name</h3>
            <input type="text" name="customer-name" id="customer-name" required/>
        </div>

        <div style="display: flex;">
            <h3>Customer Address</h3>
            <input type="text" name="customer-address" id="customer-address" required/>
        </div>
        
        
        <div style="display: flex;">
            <h3>Customer Email</h3>
            <input type="text" name="customer-email" id="customer-email" required/>
        </div>

        <div style="display: flex;">
            <h3>Customer Phone</h3>
            <input type="number" name="customer-phone" id="customer-phone" required/>
        </div>

        <button type="submit">Create Order</button>
    </form>
    <?php
}

add_filter( 'woocommerce_order_item_get_formatted_meta_data', 'change_formatted_meta_data', 20, 2 );

/**
 * Filterting the meta data of an order item.
 * @param  array         $meta_data Meta data array
 * @param  WC_Order_Item $item      Item object
 * @return array                    The formatted meta
 */
function change_formatted_meta_data( $meta_data, $item ) {
    print_r(wc_get_order_item_meta( 4, 'lens', true ));
    return $meta_data;
}
