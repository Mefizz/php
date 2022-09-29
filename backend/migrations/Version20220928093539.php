<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220928093539 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE "user_admins_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_refresh_tokens_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_reset_tokens_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_users_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "user_admins" (id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, update_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, email_value VARCHAR(50) NOT NULL, password_value VARCHAR(255) NOT NULL, locale_value SMALLINT NOT NULL, name_first VARCHAR(30) NOT NULL, name_last VARCHAR(30) NOT NULL, status_value SMALLINT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7B20E32803A19BB ON "user_admins" (email_value)');
        $this->addSql('COMMENT ON COLUMN "user_admins".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "user_admins".update_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "user_refresh_tokens" (id INT NOT NULL, refresh_token VARCHAR(128) NOT NULL, username VARCHAR(255) NOT NULL, valid TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F02938B8C74F2195 ON "user_refresh_tokens" (refresh_token)');
        $this->addSql('CREATE TABLE "user_reset_tokens" (id INT NOT NULL, user_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, update_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, token_value VARCHAR(255) NOT NULL, expire_at_value TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FF7ED315A76ED395 ON "user_reset_tokens" (user_id)');
        $this->addSql('COMMENT ON COLUMN "user_reset_tokens".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "user_reset_tokens".update_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "user_reset_tokens".expire_at_value IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "user_users" (id INT NOT NULL, last_access TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, update_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, email_value VARCHAR(50) NOT NULL, password_value VARCHAR(255) NOT NULL, name_first VARCHAR(30) NOT NULL, name_last VARCHAR(30) NOT NULL, apple_value VARCHAR(255) DEFAULT NULL, facebook_value VARCHAR(255) DEFAULT NULL, locale_value SMALLINT NOT NULL, push_notification_value SMALLINT NOT NULL, status_value SMALLINT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6415EB1803A19BB ON "user_users" (email_value)');
        $this->addSql('COMMENT ON COLUMN "user_users".last_access IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "user_users".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "user_users".update_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE "user_reset_tokens" ADD CONSTRAINT FK_FF7ED315A76ED395 FOREIGN KEY (user_id) REFERENCES "user_users" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE "user_admins_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE "user_refresh_tokens_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE "user_reset_tokens_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE "user_users_id_seq" CASCADE');
        $this->addSql('ALTER TABLE "user_reset_tokens" DROP CONSTRAINT FK_FF7ED315A76ED395');
        $this->addSql('DROP TABLE "user_admins"');
        $this->addSql('DROP TABLE "user_refresh_tokens"');
        $this->addSql('DROP TABLE "user_reset_tokens"');
        $this->addSql('DROP TABLE "user_users"');
    }
}
