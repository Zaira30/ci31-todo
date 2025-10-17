CREATE TABLE IF NOT EXISTS todos (
									 id INT AUTO_INCREMENT PRIMARY KEY,
									 title VARCHAR(255) NOT NULL,
	description TEXT NULL,
	status ENUM('pending','done') NOT NULL DEFAULT 'pending',
	created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP
	);

-- Exemplo opcional
INSERT INTO todos (title, description) VALUES
										   ('Estudar CI3', 'Ler a documentacao e exemplos'),
										   ('Montar Docker', 'Subir app e banco');
