CREATE TABLE IF NOT EXISTS owners (
    id SERIAL PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS assets (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    value NUMERIC(15,2) NOT NULL DEFAULT 0,
    status VARCHAR(50) NOT NULL DEFAULT 'active',
    owner_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_assets_owner FOREIGN KEY (owner_id) REFERENCES owners(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS transactions (
    id SERIAL PRIMARY KEY,
    asset_id INT NOT NULL,
    type VARCHAR(50) NOT NULL,
    amount NUMERIC(15,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_transactions_asset FOREIGN KEY (asset_id) REFERENCES assets(id) ON DELETE CASCADE
);

INSERT INTO owners (full_name, email, phone)
VALUES
    ('Jean Dupont', 'jean.dupont@example.com', '+33100000000'),
    ('Marie Martin', 'marie.martin@example.com', '+33111111111')
ON CONFLICT (email) DO NOTHING;

INSERT INTO assets (name, category, value, status, owner_id, created_at)
VALUES
    ('Appartement Paris', 'Immobilier', 250000.00, 'active', 1, NOW()),
    ('Actions Tech', 'Finance', 45000.00, 'active', 2, NOW()),
    ('Voiture', 'Vehicule', 18000.00, 'maintenance', 1, NOW())
ON CONFLICT DO NOTHING;

INSERT INTO transactions (asset_id, type, amount, created_at)
VALUES
    (1, 'achat', 250000.00, NOW()),
    (2, 'achat', 45000.00, NOW()),
    (3, 'entretien', 1200.00, NOW())
ON CONFLICT DO NOTHING;
