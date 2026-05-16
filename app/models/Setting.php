<?php
class Setting {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getActiveCampaign() {
        $conn = $this->db->connect();
        $stmt = $conn->prepare("SELECT * FROM home_settings WHERE is_active = 1 LIMIT 1");
        $stmt->execute();
        $result = $stmt->fetch();
        
        // If no active campaign, return a default
        if (!$result) {
            return [
                'campaign_name' => 'Oferta Especial',
                'hero_title' => 'Refresca Tu Mente y Sentimientos',
                'hero_subtitle' => 'Oferta Exclusiva - 10% de descuento esta semana',
                'hero_button_text' => 'Comprar Ahora',
                'hero_image_url' => 'https://images.unsplash.com/photo-1520763185298-1b434c919102?q=80&w=1000&auto=format&fit=crop',
                'hero_bg_color' => '#F5E6EB'
            ];
        }
        return $result;
    }

    public function getAllCampaigns() {
        $conn = $this->db->connect();
        $stmt = $conn->prepare("SELECT * FROM home_settings ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function activateCampaign($id) {
        $conn = $this->db->connect();
        
        // Deactivate all
        $conn->query("UPDATE home_settings SET is_active = 0");
        
        // Activate the selected one
        $stmt = $conn->prepare("UPDATE home_settings SET is_active = 1 WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
