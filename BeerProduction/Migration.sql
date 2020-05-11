
CREATE TYPE product AS ENUM ('Pilsner', 'Wheat', 'IPA', 'Stout', 'Ale', 'Alcohol_free');


Create Table Batch_reports(
    Batch_id SERIAL PRIMARY KEY,
    Product_type int NOT NULL,
    Batch_size INT NOT NULL,
    Acceptable_products INT NOT NULL,
    Defect_products INT NOT NULL,
    Production_speed INT NOT NULL
);