--Dropping tables before creating (batch_report has to be done last hence the 2 others depend on it)
DROP TABLE IF EXISTS State_log;
DROP TABLE IF EXISTS Environmental_log;
DROP TABLE IF EXISTS Batch_report;

-- Batch Report Table
CREATE TABLE Batch_report
(
    Batch_id SERIAL PRIMARY KEY,
    Product_type int NOT NULL,
    Batch_size INT NOT NULL,
    Produced_products INT NOT NULL,
    Defect_products INT NOT NULL,
    Production_speed INT NOT NULL,
    Start_time TIMESTAMP NOT NULL
);
-- STATE LOG TABLE
CREATE TABLE State_log
(
    Statelog_id SERIAL PRIMARY KEY,
    Batch_id INT NOT NULL REFERENCES Batch_report(Batch_id),
    Deactivated_state FLOAT NOT NULL,
    Clearing_state FLOAT NOT NULL,
    Stopped_state FLOAT NOT NULL,
    Starting_state FLOAT NOT NULL,
    Idle_state FLOAT NOT NULL,
    Suspended_state FLOAT NOT NULL,
    Execute_state FLOAT NOT NULL,
    Stopping_state FLOAT NOT NULL,
    Aborting_state FLOAT NOT NULL,
    Aborted_state FLOAT NOT NULL,
    Holding_state FLOAT NOT NULL,
    Held_state FLOAT NOT NULL,
    Resetting_state FLOAT NOT NULL,
    Completing_state FLOAT NOT NULL,
    Completed_state FLOAT NOT NULL,
    Deactive_state FLOAT NOT NULL,
    Activating_state FLOAT NOT NULL
);
--ENVIRONMENTAL LOG TABLE
CREATE TABLE Environmental_log
(
    Environmental_log_id SERIAL PRIMARY KEY,
    Batch_id INT NOT NULL REFERENCES Batch_report(Batch_id),
    Temperature REAL NOT NULL,
    Humidity REAL NOT NULL,
    Vibration REAL NOT NULL,
    Log_time TIMESTAMP NOT NULL
);
