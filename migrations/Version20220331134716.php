<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220331134716 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, carte_id INT NOT NULL, user_id INT NOT NULL, seance_id INT NOT NULL, prix INT NOT NULL, INDEX IDX_42C84955C9C7CEB6 (carte_id), INDEX IDX_42C84955A76ED395 (user_id), INDEX IDX_42C84955E3797A94 (seance_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation_siege (reservation_id INT NOT NULL, siege_id INT NOT NULL, INDEX IDX_24796450B83297E7 (reservation_id), INDEX IDX_24796450BF006E8B (siege_id), PRIMARY KEY(reservation_id, siege_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955C9C7CEB6 FOREIGN KEY (carte_id) REFERENCES carte_bancaire (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955E3797A94 FOREIGN KEY (seance_id) REFERENCES seance (id)');
        $this->addSql('ALTER TABLE reservation_siege ADD CONSTRAINT FK_24796450B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation_siege ADD CONSTRAINT FK_24796450BF006E8B FOREIGN KEY (siege_id) REFERENCES siege (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation_siege DROP FOREIGN KEY FK_24796450B83297E7');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE reservation_siege');
    }
}
