DROP PROCEDURE IF EXISTS spGetStockDetails;
DELIMITER $$

CREATE PROCEDURE spGetStockDetails(IN varCategory VARCHAR(255), IN varCompany VARCHAR(255))
BEGIN
    IF varCategory IS NULL AND varCompany IS NULL THEN
        SELECT DISTINCT category_name FROM product_categories;
    ELSE
        SELECT 
            S.id AS StockId,
            P.product_name AS Product,
            PC.category_name AS Category,
            SUP.company_name AS Company,
            S.amount AS Amount,
            S.date_created AS DateCreated
        FROM stocks S
        INNER JOIN products P ON P.id = S.product_id
        INNER JOIN product_categories PC ON PC.id = P.product_category_id
        INNER JOIN suppliers SUP ON SUP.id = P.supplier_id
        WHERE S.is_active = 1
          AND PC.category_name COLLATE utf8mb4_unicode_ci = varCategory COLLATE utf8mb4_unicode_ci
          AND SUP.company_name COLLATE utf8mb4_unicode_ci = varCompany COLLATE utf8mb4_unicode_ci;
    END IF;
END$$

DELIMITER ;