-- CREATE (Insert new customer)
DELIMITER $$
CREATE PROCEDURE sp_create_customer(
    IN p_family_contact_persons_id INT,
    IN p_amount_adults INT,
    IN p_amount_children INT,
    IN p_amount_babies INT,
    IN p_special_wishes VARCHAR(255),
    IN p_family_name VARCHAR(100),
    IN p_address VARCHAR(255),
    IN p_is_active BOOLEAN
)
BEGIN
    INSERT INTO customers (
        family_contact_persons_id,
        amount_adults,
        amount_children,
        amount_babies,
        special_wishes,
        family_name,
        address,
        is_active,
        date_created,
        updated_at
    ) VALUES (
        p_family_contact_persons_id,
        p_amount_adults,
        p_amount_children,
        p_amount_babies,
        p_special_wishes,
        p_family_name,
        p_address,
        p_is_active,
        NOW(),
        NOW()
    );
END$$

-- READ (Get all customers)
CREATE PROCEDURE sp_get_customers()
BEGIN
    SELECT * FROM customers ORDER BY date_created DESC;
END$$

-- UPDATE (Update customer by id)
CREATE PROCEDURE sp_update_customer(
    IN p_id INT,
    IN p_family_contact_persons_id INT,
    IN p_amount_adults INT,
    IN p_amount_children INT,
    IN p_amount_babies INT,
    IN p_special_wishes VARCHAR(255),
    IN p_family_name VARCHAR(100),
    IN p_address VARCHAR(255),
    IN p_is_active BOOLEAN
)
BEGIN
    UPDATE customers SET
        family_contact_persons_id = p_family_contact_persons_id,
        amount_adults = p_amount_adults,
        amount_children = p_amount_children,
        amount_babies = p_amount_babies,
        special_wishes = p_special_wishes,
        family_name = p_family_name,
        address = p_address,
        is_active = p_is_active,
        updated_at = NOW()
    WHERE id = p_id;
END$$

-- DELETE (Delete customer by id)
CREATE PROCEDURE sp_delete_customer(
    IN p_id INT
)
BEGIN
    DELETE FROM customers WHERE id = p_id;
END$$

DELIMITER ;
