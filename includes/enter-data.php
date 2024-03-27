<?php 
  include('config.php');
    try {

            // SQL query to select data
            $sql = "SELECT 
                order_products.order_id,
                order_products.product_id,
                order_products.qty,
                order_products.amt,
                products.product_code,
                products.product_title, 
                products.product_price,
                orders_info.order_id, 
                orders_info.prod_count, 
                orders_info.total_amt, 
                orders_info.f_name, 
                orders_info.user_id, 
                orders_info.contact, 
                orders_info.email, 
                orders_info.address, 
                orders_info.status,
                orders_info.date
            FROM 
                order_products
            JOIN 
                products 
            ON 
                order_products.product_id = products.product_id
            JOIN
                orders_info
            ON
                order_products.order_id = orders_info.order_id
            ORDER BY 
                order_products.product_id";

            // execute SQL query and get result set
            $stmt = $dbh->query($sql);

            // insert the selected data into the database if it doesn't already exist
            $insert_query = "INSERT INTO sales_orders (order_id, product_id, product_title, quantity, amt, product_code, product_price, prod_count, total_amt, f_name, user_id, contact, email, address, status,date) 
                SELECT order_products.order_id, order_products.product_id, products.product_title, order_products.qty, order_products.amt, products.product_code, products.product_price, orders_info.prod_count, orders_info.total_amt, orders_info.f_name, orders_info.user_id, orders_info.contact, orders_info.email, orders_info.address, orders_info.status, orders_info.date 
                FROM order_products 
                JOIN products ON order_products.product_id = products.product_id 
                JOIN orders_info ON order_products.order_id = orders_info.order_id 
                WHERE NOT EXISTS (
                    SELECT * FROM sales_orders WHERE sales_orders.order_id = order_products.order_id
                )";

            // Update the status in sales_orders table based on the latest status in orders_info table
            $update_status_query = "UPDATE sales_orders
                JOIN orders_info ON sales_orders.order_id = orders_info.order_id
                SET sales_orders.status = orders_info.status
                WHERE sales_orders.status <> orders_info.status";

            $dbh->query($insert_query);
            $dbh->query($update_status_query);
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        // close database connection
        // $dbh = null;
    

?>
