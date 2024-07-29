<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Section_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        header('Content-Type: application/json');
    }

    public function apiResult($result, $statusCode)
    {
        $statusMessage = $statusCode === 200 ? 'OK' : $this->getStatusMessage($statusCode);
        $response = array(
            'status' => $statusCode,
            'message' => $statusMessage,
            'data' => $result
        );

        $this->output->set_status_header($statusCode)
            ->set_output(json_encode($response));
    }

    private function getStatusMessage($statusCode)
    {
        $statusMessages = array(
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error'
        );

        return isset($statusMessages[$statusCode]) ? $statusMessages[$statusCode] : 'Unknown Status';
    }

    public function sections()
    {
        $output1 = $this->Section_model->sections();
        $output2 = $this->Sector_model->get_sectorAll();

        $output1 = json_decode(json_encode($output1), true);
        $output2 = json_decode(json_encode($output2), true);

        if ($output1 && $output2) {
            $sectorMap = [];
            foreach ($output2 as $sector) {
                $sectorMap[$sector['id']] = $sector['sector_name'];
            }

            $result = [];
            foreach ($output1 as $section) {
                $formattedSection = [
                    'id' => $section['id'],
                    'name' => $section['name'],
                    'slug' => $section['slug'],
                    'sector' => $section['sector_id'],
                    'sector_name' => isset($sectorMap[$section['sector_id']]) ? $sectorMap[$section['sector_id']] : 'Unknown',
                    'order_type' => $section['order_type']
                ];

                $formattedSection['delivery_type'] = [];

                foreach ($section as $key => $value) {
                    if (strpos($key, 'delivery_type_') === 0) {
                        $deliveryTypeKey = str_replace('delivery_type_', '', $key);
                        $formattedSection['delivery_type'][$deliveryTypeKey] = $value == '1';
                    }
                }
                $result[] = $formattedSection;
            }

            return $this->apiResult($result, 200);
        } else {
            return $this->apiResult(['message' => 'section not exists'], 404);
        }

        return $this->apiResult(['message' => 'server error'], 500);
    }

    public function add_sections($id)
    {
        $data = [
            "name" => $this->input->post('name'),
            "slug" => $this->input->post('slug'),
            "order_type" => $this->input->post('order_type'),
            "delivery_type_inshop" => $this->input->post("delivery_type_inshop"),
            "delivery_type_takeaway" => $this->input->post("delivery_type_takeaway"),
            "delivery_type_hyperlocal" => $this->input->post("delivery_type_hyperlocal"),
            "delivery_type_courier" => $this->input->post("delivery_type_courier"),
            "sector_id" => $id
        ];

        $result = $this->db->Section_model->create_section($data);
        if ($result) {
            return $this->apiResult(['message' => 'created section'], 200);
        } else {
            return $this->apiResult(['message' => 'section not exists'], 404);
        }
        return $this->apiResult(['message' => 'server error'], 500);
    }

    public function edit_section($id)
    {
        $data = [
            "name" => $this->input->post('name'),
            "slug" => $this->input->post('slug'),
            "order_type" => $this->input->post('order_type'),
            "delivery_type_inshop" => $this->input->post("delivery_type_inshop"),
            "delivery_type_takeaway" => $this->input->post("delivery_type_takeaway"),
            "delivery_type_hyperlocal" => $this->input->post("delivery_type_hyperlocal"),
            "delivery_type_courier" => $this->input->post("delivery_type_courier"),
        ];

        if ($this->Section_model->section($id)) {
            $query = $this->Section_model->section_update($id);
            if ($query) {
                return $this->apiResult(['message' => 'section updated'], 500);
            }
            return $this->apiResult(['message' => 'absent of sector'], 404);
        }
        return $this->apiResult(['message' => 'server error'], 500);
    }

    public function section($id)
    {
        $result = $this->Section_model->section($id);
        if ($result) {
            return $this->apiResult($result, 200);
        } else {
            return $this->apiResult(['message' => 'section not exists'], 404);
        }
        return $this->apiResult(['message' => 'server error'], 500);
    }
}
