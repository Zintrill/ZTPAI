<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250113200510 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE device (id SERIAL NOT NULL, type_id INT DEFAULT NULL, snmp_version_id INT DEFAULT NULL, device_name VARCHAR(255) NOT NULL, address_ip VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_92FB68EC54C8C93 ON device (type_id)');
        $this->addSql('CREATE INDEX IDX_92FB68EA95134DE ON device (snmp_version_id)');
        $this->addSql('CREATE TABLE device_status (id SERIAL NOT NULL, device_id INT DEFAULT NULL, mac_address VARCHAR(255) NOT NULL, status VARCHAR(20) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A810140794A4C7D4 ON device_status (device_id)');
        $this->addSql('CREATE TABLE permission (permission_id SERIAL NOT NULL, role VARCHAR(50) NOT NULL, PRIMARY KEY(permission_id))');
        $this->addSql('CREATE TABLE project (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, completed BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE snmp_version (snmp_version_id SERIAL NOT NULL, snmp VARCHAR(255) NOT NULL, PRIMARY KEY(snmp_version_id))');
        $this->addSql('CREATE TABLE type (type_id SERIAL NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(type_id))');
        $this->addSql('CREATE TABLE user_details (id SERIAL NOT NULL, user_id INT DEFAULT NULL, address VARCHAR(255) NOT NULL, phone_number VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2A2B1580A76ED395 ON user_details (user_id)');
        $this->addSql('CREATE TABLE user_device (user_id INT NOT NULL, device_id INT NOT NULL, PRIMARY KEY(user_id, device_id))');
        $this->addSql('CREATE INDEX IDX_6C7DADB3A76ED395 ON user_device (user_id)');
        $this->addSql('CREATE INDEX IDX_6C7DADB394A4C7D4 ON user_device (device_id)');
        $this->addSql('CREATE TABLE users (user_id SERIAL NOT NULL, permission_id INT DEFAULT NULL, fullname VARCHAR(100) NOT NULL, username VARCHAR(50) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(100) NOT NULL, roles JSON NOT NULL, PRIMARY KEY(user_id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9F85E0677 ON users (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
        $this->addSql('CREATE INDEX IDX_1483A5E9FED90CCA ON users (permission_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE device ADD CONSTRAINT FK_92FB68EC54C8C93 FOREIGN KEY (type_id) REFERENCES type (type_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE device ADD CONSTRAINT FK_92FB68EA95134DE FOREIGN KEY (snmp_version_id) REFERENCES snmp_version (snmp_version_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE device_status ADD CONSTRAINT FK_A810140794A4C7D4 FOREIGN KEY (device_id) REFERENCES device (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_details ADD CONSTRAINT FK_2A2B1580A76ED395 FOREIGN KEY (user_id) REFERENCES users (user_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_device ADD CONSTRAINT FK_6C7DADB3A76ED395 FOREIGN KEY (user_id) REFERENCES users (user_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_device ADD CONSTRAINT FK_6C7DADB394A4C7D4 FOREIGN KEY (device_id) REFERENCES device (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9FED90CCA FOREIGN KEY (permission_id) REFERENCES permission (permission_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE device DROP CONSTRAINT FK_92FB68EC54C8C93');
        $this->addSql('ALTER TABLE device DROP CONSTRAINT FK_92FB68EA95134DE');
        $this->addSql('ALTER TABLE device_status DROP CONSTRAINT FK_A810140794A4C7D4');
        $this->addSql('ALTER TABLE user_details DROP CONSTRAINT FK_2A2B1580A76ED395');
        $this->addSql('ALTER TABLE user_device DROP CONSTRAINT FK_6C7DADB3A76ED395');
        $this->addSql('ALTER TABLE user_device DROP CONSTRAINT FK_6C7DADB394A4C7D4');
        $this->addSql('ALTER TABLE users DROP CONSTRAINT FK_1483A5E9FED90CCA');
        $this->addSql('DROP TABLE device');
        $this->addSql('DROP TABLE device_status');
        $this->addSql('DROP TABLE permission');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE snmp_version');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE user_details');
        $this->addSql('DROP TABLE user_device');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
