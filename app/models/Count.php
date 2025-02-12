<?php
include_once __DIR__ . '/../../includes/database.php';

class Count
{
    protected $db;

    public function __construct()
    {
        try {
            $this->db = db_connect();
        } catch (PDOException $e) {
            die("Kết nối thất bại: " . $e->getMessage());
        }
    }

    public function countUser()
    {
        $sql = "SELECT COUNT(*) FROM users";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count;
    }

    public function countBill()
    {
        $sql = "SELECT COUNT(*) FROM bill";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count;
    }

    public function countTotal()
    {
        $sql = "SELECT SUM(total) FROM bill";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count;
    }

    public function getChart()
    {
        $sql = "SELECT DATE_FORMAT(created_at, '%Y-%m-%d') AS day,
               SUM(total) AS total_revenue
        FROM 
            bill
        GROUP BY 
            day
        ORDER BY 
            day;";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }
}
