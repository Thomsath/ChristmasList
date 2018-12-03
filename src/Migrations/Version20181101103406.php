<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181101103406 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE gift (id INT AUTO_INCREMENT NOT NULL, giftslist_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, source VARCHAR(255) DEFAULT NULL, username VARCHAR(255) NOT NULL, INDEX IDX_A47C990DFF2D523D (giftslist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gifts_list (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, UNIQUE INDEX UNIQ_7CAB1DF5A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_users (id INT AUTO_INCREMENT NOT NULL, giftslist_id INT NOT NULL, username VARCHAR(25) NOT NULL, password VARCHAR(64) NOT NULL, email VARCHAR(60) NOT NULL, is_active TINYINT(1) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_C2502824F85E0677 (username), UNIQUE INDEX UNIQ_C2502824E7927C74 (email), UNIQUE INDEX UNIQ_C2502824FF2D523D (giftslist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gift ADD CONSTRAINT FK_A47C990DFF2D523D FOREIGN KEY (giftslist_id) REFERENCES gifts_list (id)');
        $this->addSql('ALTER TABLE gifts_list ADD CONSTRAINT FK_7CAB1DF5A76ED395 FOREIGN KEY (user_id) REFERENCES app_users (id)');
        $this->addSql('ALTER TABLE app_users ADD CONSTRAINT FK_C2502824FF2D523D FOREIGN KEY (giftslist_id) REFERENCES gifts_list (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE gift DROP FOREIGN KEY FK_A47C990DFF2D523D');
        $this->addSql('ALTER TABLE app_users DROP FOREIGN KEY FK_C2502824FF2D523D');
        $this->addSql('ALTER TABLE gifts_list DROP FOREIGN KEY FK_7CAB1DF5A76ED395');
        $this->addSql('DROP TABLE gift');
        $this->addSql('DROP TABLE gifts_list');
        $this->addSql('DROP TABLE app_users');
    }
}
