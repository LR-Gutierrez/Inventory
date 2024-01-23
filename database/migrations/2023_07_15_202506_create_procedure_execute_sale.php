<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $sql = "
        CREATE OR REPLACE PROCEDURE execute_sale(in_customer_id INT, in_coupon_code TEXT, in_date TIMESTAMP, in_created_by INT)
        LANGUAGE plpgsql
        AS $$
            DECLARE
                registro RECORD;
                total DOUBLE PRECISION;
                registries INT;
                last_sale_id INT;
                coupon_id INT = NULL;
                discount DOUBLE PRECISION;
            BEGIN
                SELECT COUNT(*) INTO registries FROM temp_orders WHERE customer_id = in_customer_id;

                IF registries > 0 THEN                
                    SELECT SUM(item_quantity * price) INTO total FROM temp_orders WHERE customer_id = in_customer_id;

                    IF in_coupon_code IS NOT NULL THEN
                        SELECT id, discount_amount INTO coupon_id, discount FROM coupons WHERE coupon_code = 'in_coupon_code';
                        IF coupon_id IS NOT NULL THEN
                            total := total - ((total * discount) / 100);
                            UPDATE coupons SET claimable = claimable - 1 WHERE id = coupon_id;
                        ELSE
                            coupon_id := NULL;
                        END IF;
                    END IF;

                    INSERT INTO sales (customer_id, coupon_id, total_sale, created_at, created_by) VALUES (in_customer_id, coupon_id, total, in_date, in_created_by)
                    RETURNING id INTO last_sale_id;
                    
                    FOR registro IN SELECT customer_id,product_id,item_quantity,price,created_at,created_by FROM temp_orders WHERE customer_id = in_customer_id LOOP
                        INSERT INTO detail_sales (sale_id, product_id, item_quantity, price, created_at,created_by) VALUES (last_sale_id, registro.product_id, registro.item_quantity, registro.price, registro.created_at,registro.created_by);
                    
                    END LOOP;


                    DELETE FROM temp_orders WHERE customer_id = in_customer_id;
                ELSE
                    SELECT 0;
                END IF;
            END;
        $$;
        ";

    DB::unprepared($sql);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $sql = "DROP PROCEDURE IF EXISTS execute_sale;";
        DB::unprepared($sql);
    }
};
