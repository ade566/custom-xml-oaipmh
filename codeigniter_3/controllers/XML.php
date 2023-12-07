<?php

defined('BASEPATH') or exit('No direct script access allowed');

class XML extends CI_Controller
{

	public function index()
	{
		$offset = $this->input->get('offset') ?? 0;
		$limit = $this->input->get('limit') ?? 0;

    $query = $this->db->get('client', $limit, $offset)->result_array();

		$xml = '<OAI-PMH xmlns="https://www.openarchives.org/OAI/2.0/" xmlns:xsi="https://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="https://www.openarchives.org/OAI/2.0/ https://www.openarchives.org/OAI/2.0/OAI-PMH.xsd">
		<ListRecords>';
		foreach($query as $row){
			$xml .= '<record>
				<metadata>
					<oai_dc:dc xmlns:oai_dc="https://www.openarchives.org/OAI/2.0/oai_dc/" xmlns:dc="https://purl.org/dc/elements/1.1/" xmlns:xsi="https://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="https://www.openarchives.org/OAI/2.0/oai_dc/ https://www.openarchives.org/OAI/2.0/oai_dc.xsd">
						<dc:name>'.html_escape($row['name']).'</dc:name>
						<dc:email>'.html_escape($row['email']).'</dc:email>
						<dc:address>'.html_escape($row['address']).'</dc:address>
						<dc:status>'.html_escape($row['status']).'</dc:status>
					</oai_dc:dc>
				</metadata>
			</record>';
		}
		$xml .= '</ListRecords>
		</OAI-PMH>';
		
		$this->output->set_content_type('text/xml');
		$this->output->set_output($xml);
	}

}
