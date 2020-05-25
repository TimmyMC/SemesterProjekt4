SELECT * FROM environmental_log
SELECT * FROM Batch_report
SELECT * FROM State_log




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
    Temperature REAL,
    Humidity REAL,
    Vibration REAL,
    Log_time TIMESTAMP NOT NULL
);


--DUMMY ENTRIES BATCH_REPORT
INSERT INTO Batch_report(Batch_id, Product_type, Batch_size, Produced_products, Defect_products, Production_speed, Start_time)
VALUES  (1,0,200,198,2,100,now()),
        (2,0,200,197,3,100,now()),
        (3,1,200,187,13,100,now()),
        (4,1,200,195,5,100,now()),
        (5,2,200,197,3,100,now()),
        (6,2,200,192,8,100,now()),
        (7,3,200,195,5,100,now()),
        (8,3,200,194,6,100,now()),
        (9,4,200,193,7,100,now()),
        (10,4,200,197,3,100,now()),
        (11,5,200,196,4,100,now()),
        (12,5,200,194,6,100,now());

--DUMMY ENTRIES STATE_LOG
INSERT INTO State_log(Batch_id, Deactivated_state, Clearing_state, Stopped_state, Starting_state, Idle_state, Suspended_state, Execute_state, Stopping_state, Aborting_state, Aborted_state, Holding_state, Held_state, Resetting_state, Completing_state, Completed_state, Deactive_state, Activating_state)
VALUES  (1,0,0,0,1,0,0,120,0,0,0,0,0,0,1,2,0,0),
        (2,0,0,0,1,0,0,120,0,0,0,0,0,0,1,1,0,0),
        (3,0,0,0,1,0,0,120,0,0,0,0,0,0,1,3,0,0),
        (4,0,0,0,1,0,0,120,0,0,0,0,0,0,1,5,0,0),
        (5,0,0,0,1,0,0,120,0,0,0,0,0,0,1,6,0,0),
        (6,0,0,0,1,0,0,120,0,0,0,0,0,0,1,3,0,0),
        (7,0,0,0,1,0,0,120,0,0,0,0,0,0,1,2,0,0),
        (8,0,0,0,1,0,0,120,0,0,0,0,0,0,1,1,0,0),
        (9,0,0,0,1,0,0,120,0,0,0,0,0,0,1,1,0,0),
        (10,0,0,0,1,0,0,120,0,0,0,0,0,0,1,2,0,0),
        (11,0,0,0,1,0,0,120,0,0,0,0,0,0,1,5,0,0),
        (12,0,0,0,1,0,0,120,0,0,0,0,0,0,1,4,0,0);

--DUMMY ENTRIES ENVIRONMENTAL_LOG
INSERT INTO Environmental_log (Batch_id, Temperature, Humidity, Vibration, Log_time)
VALUES  (1,16,45,1,now()), 
        (2,17,45,5,now()),
        (3,16,48,3,now()),
        (4,15,47,0,now()),
        (5,15,55,2,now()),
        (6,16,56,1,now()),
        (7,17,55,3,now()),
        (8,16,50,0,now()),
        (9,16,40,0,now()),
        (10,16,47,2,now()),        
        (11,15,49,1,now()),
        (12,17,50,2,now());