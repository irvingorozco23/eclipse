-- PostgreSQL Database for Restaurant Reservation System

CREATE TABLE IF NOT EXISTS tables (
    id SERIAL PRIMARY KEY,
    number INT UNIQUE NOT NULL,
    capacity INT NOT NULL,
    status VARCHAR(20) DEFAULT 'available'
);

CREATE TABLE IF NOT EXISTS dishes (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL
);

CREATE TABLE IF NOT EXISTS reservations (
    id SERIAL PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    customer_email VARCHAR(100),
    reservation_date TIMESTAMP NOT NULL,
    table_id INT REFERENCES tables(id),
    status VARCHAR(20) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS reservation_dishes (
    id SERIAL PRIMARY KEY,
    reservation_id INT REFERENCES reservations(id) ON DELETE CASCADE,
    dish_id INT REFERENCES dishes(id),
    quantity INT DEFAULT 1
);

-- Insert dummy data
INSERT INTO tables (number, capacity) VALUES (1, 2), (2, 4), (3, 6) ON CONFLICT DO NOTHING;
INSERT INTO dishes (name, description, price) VALUES 
('Burger', 'Delicious beef burger', 12.50), 
('Pizza', 'Margherita pizza', 15.00), 
('Pasta', 'Spaghetti Carbonara', 14.00);

CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin user (password format is password_hash for 'admin123')
INSERT INTO users (username, password, role) 
VALUES ('admin', '$2y$10$LH4k91/1SCj.1Ym6Jmrv2O7F.2hkYkiVOMI2hDlVapnUWTe1tuDFG', 'admin') 
ON CONFLICT (username) DO NOTHING;

