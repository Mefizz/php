<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220928102541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE user_admins_id_seq CASCADE');
        $this->addSql('DROP TABLE user_admins');
        $this->addSql('ALTER TABLE user_users ADD balance_balance DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE user_users DROP last_access');
        $this->addSql('ALTER TABLE user_users DROP created_at');
        $this->addSql('ALTER TABLE user_users DROP update_at');
        $this->addSql('ALTER TABLE user_users DROP name_first');
        $this->addSql('ALTER TABLE user_users DROP name_last');
        $this->addSql('ALTER TABLE user_users DROP apple_value');
        $this->addSql('ALTER TABLE user_users DROP facebook_value');
        $this->addSql('ALTER TABLE user_users DROP locale_value');
        $this->addSql('ALTER TABLE user_users DROP push_notification_value');
        $this->addSql('ALTER TABLE user_users DROP status_value');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE user_admins_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE user_admins (id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, update_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, email_value VARCHAR(50) NOT NULL, password_value VARCHAR(255) NOT NULL, locale_value SMALLINT NOT NULL, name_first VARCHAR(30) NOT NULL, name_last VARCHAR(30) NOT NULL, status_value SMALLINT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_c7b20e32803a19bb ON user_admins (email_value)');
        $this->addSql('COMMENT ON COLUMN user_admins.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN user_admins.update_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE "user_users" ADD last_access TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE "user_users" ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE "user_users" ADD update_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE "user_users" ADD name_first VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE "user_users" ADD name_last VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE "user_users" ADD apple_value VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user_users" ADD facebook_value VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user_users" ADD locale_value SMALLINT NOT NULL');
        $this->addSql('ALTER TABLE "user_users" ADD push_notification_value SMALLINT NOT NULL');
        $this->addSql('ALTER TABLE "user_users" ADD status_value SMALLINT NOT NULL');
        $this->addSql('ALTER TABLE "user_users" DROP balance_balance');
        $this->addSql('COMMENT ON COLUMN "user_users".last_access IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "user_users".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "user_users".update_at IS \'(DC2Type:datetime_immutable)\'');
    }
}
