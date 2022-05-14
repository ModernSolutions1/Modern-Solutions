<?php include('partials/header.php')?>

<style type="text/css" media="print">
    @media print{
        .noprint, .noprint *{
            display: none !important;
        }
    }
</style>

<body onload="print()">
<section style="width: 100%; background-color:white;">
<section style=" width: 100%; padding: 50px 100px;">
<?php

    if(isset($_GET['print'])){   
        $order_id =  $_GET['print'];

        $sql = "SELECT * FROM tbl_order WHERE order_id=$order_id LIMIT 1";
        $sql_run = mysqli_query($conn, $sql);
        $fetch = mysqli_fetch_assoc($sql_run);

        if($fetch['order_status'] == 'Preparing'){
            $color = "blue";
        }
        elseif($fetch['order_status'] == 'Pending'){
            $color = "orangered";
        }
        elseif($fetch['order_status'] == 'Cancelled'){
            $color = "red";
        }
        elseif($fetch['order_status'] == 'On-Delivery'){
            $color = "purple";
        }
        elseif($fetch['order_status'] == 'Delivered'){
            $color = "green";
        }

        if(mysqli_num_rows($sql_run)>0){
            ?>
            <button class="noprint" style="background-color: blue; border: none; padding: 5px 10px; color:white; margin-bottom: 20px; border-radius: 5px;" onclick="window.location.replace('order-info.php?order_id=<?php echo $order_id;?>&order_page=TRUE');">Cancel</button>
                <h5>Order ID: <span style="font-size:20px;">#<?php echo $fetch['order_id'];?></span></h5>
                <br>          
                <!-- <h5>Status: <span style="color:<?php echo $color;?>"><?php echo $fetch['order_status'];?></span></h5> -->
                <!-- <h5>Order Date: <span><?php echo $fetch['placed_order_date'];?></span></h5> -->
                <h5>Delivery: <span><?php echo $fetch['target_order_date'];?></span></h5>
                <br>
                <h5>Name: <span><?php echo $fetch['fullname'];?></span></h5>
                <h5>Address: <span><?php echo $fetch['to_street'].', '.$fetch['to_barangay'].' '.$fetch['to_city'];?></span></h5>
                <h5>Phone: <span><?php echo $fetch['phone'];?></span></h5>
                <br>
                <div style="width:100%">
                    <div style="display:flex; width:100%; justify-content: space-between; margin-top:20px; align-items:center">
                        <div><h5>Products</h5></div>
                        <h6>If a product is not available <span style="color:red">**<?=$fetch['replacement'];?>**</span></h6>
                    </div>
                    <div style="border: 1px solid #ccc; padding: 5px; margin-top:10px">
                        <?php
                            $items = $fetch['ordered_items'];
                            $items = explode(',', $fetch['ordered_items']);

                            $i = 0;
                            $count = count($items);

                            while($count>0){
                                ?>
                                <h5 style="text-transform: uppercase;"><?= $items[$i];?></h5>
                                <?php 

                                $i++;
                                $count--;
                            }
                        ?>
                    </div>
                    <div style="padding:10px 0 0 0; display:flex; justify-content: space-between;">
                        <h5>Total</h5>
                        <h3><span style="color:red;"><?php echo 'P '.$fetch['total_price']+$fetch['delivery_fee'].'.00';?></span><span style="font-size:12px;">(with <?php echo $fetch['delivery_fee']; ?> delivery fee)</span></h3>
                    </div>
                </div>
                <br>
                <div>
                </div>
                <h6>Note</h6>
                <textarea style="background-color: white; border: none"name="" id="" cols="50%" rows="5" disabled><?php if($fetch['instruction'] != ''){echo $fetch['instruction'];} else{ echo 'No notes.';}?></textarea>
                <br>
                <br>
                <?php

                
                ?>
                
            <?php
        }
    }
?>
</section>
</section>

</body>
