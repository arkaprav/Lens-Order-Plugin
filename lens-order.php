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
    $products = array();
    foreach ( $products_query as $product ) {

        $products[] = $product->get_data();
    }
	?>
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
                    VD
                </th>
                <th>
                    Near ADD
                </th>
                <th>
                    VN
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
                        <?php for ($i=0; $i < 10; $i++) { 
                            ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php
                        } ?>
                    </select>
                </td>
                <td>
                    <select name='right_vd' id='right_vd'>
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
                    <select name='right_vn' id='right_vn'>
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
                        <?php for ($i=0; $i < 10; $i++) { 
                            ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php
                        } ?>
                    </select>
                </td>
                <td>
                    <select name='left_vd' id='left_vd'>
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
                    <select name='left_vn' id='left_vn'>
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
    <div class="lens-section" style="display: flex; width: 800px;">
        <h3>Lens</h3>
        <select name="len-name" id="lens-name">
            <?php
                foreach ($products as $product) {
                    ?>
                        <option value=<?php echo $product['id']?>><?php echo $product['name']?></option>
                    <?php
                }
            ?>
        </select>

        <h3>Lens Type</h3>
        <select name="len-type" id="lens-type">
            <option value="distance">Distance</option>
            <option value="near">Near</option>
            <option value="bifocal">BiFocal</option>
        </select>
        
        <h3>Lens Side</h3>
        <select name="len-side" id="lens-side">
            <option value="right">Right</option>
            <option value="left">Left</option>
            <option value="both">Both</option>
        </select>
        <h3>Lens Price</h3>
        <input type="number"name="lens-price" id="lens-price" />
    </div>
    <?php
}