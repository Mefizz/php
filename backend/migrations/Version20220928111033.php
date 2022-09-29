<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220928111033 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payment_payment ADD sender_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE payment_payment ADD recipient_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE payment_payment ADD CONSTRAINT FK_74618AE7F624B39D FOREIGN KEY (sender_id) REFERENCES "user_users" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE payment_payment ADD CONSTRAINT FK_74618AE7E92F8F78 FOREIGN KEY (recipient_id) REFERENCES "user_users" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_74618AE7F624B39D ON payment_payment (sender_id)');
        $this->addSql('CREATE INDEX IDX_74618AE7E92F8F78 ON payment_payment (recipient_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "payment_payment" DROP CONSTRAINT FK_74618AE7F624B39D');
        $this->addSql('ALTER TABLE "payment_payment" DROP CONSTRAINT FK_74618AE7E92F8F78');
        $this->addSql('DROP INDEX IDX_74618AE7F624B39D');
        $this->addSql('DROP INDEX IDX_74618AE7E92F8F78');
        $this->addSql('ALTER TABLE "payment_payment" DROP sender_id');
        $this->addSql('ALTER TABLE "payment_payment" DROP recipient_id');
    }
}
