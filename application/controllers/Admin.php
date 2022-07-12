<?php

use phpDocumentor\Reflection\Types\This;

defined('BASEPATH') or exit('No direct script access allowed');
class Admin extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->login) {
			redirect(base_url('Auth'));
		}
	}
	public function index()
	{
		$data['html']['title'] = 'Dasboard';
		$this->template($data);
	}

	public function itemTypeList()
	{
		$tableName = 'itemtype';

		$join = array(
			array('account', 'account.pkey=' . $tableName . '.createon', 'left'),
			array('role', 'role.pkey=account.role', 'left'),
		);
		$select = '
			' . $tableName . '.*,
			account.name as createname,
			account.role as createrole,
			role.name as rolename,
		';

		$dataList = $this->getDataRow($tableName, $select, '', '', $join);
		$data['html']['title'] = 'List Kondisi Barang';
		$data['html']['dataList'] = $dataList;
		$data['html']['tableName'] = $tableName;
		$data['html']['form'] = get_class($this) . '/itemType';
		$data['url'] = 'admin/itemTypeList';
		$this->template($data);
	}

	public function itemType($id = '')
	{
		$tableName = 'itemtype';
		$tableDetail = '';
		$baseUrl = get_class($this) . '/' . __FUNCTION__;
		$detailRef = '';
		$formData = array(
			'pkey' => 'pkey',
			'name' => 'name',
			'createon' => 'sesionid',
			'time' => 'time',
		);
		$formDetail = array();

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (empty($_POST['action'])) redirect(base_url($baseUrl . 'List'));
			//validate form
			$arrMsgErr = array();
			if (empty($_POST['name']))
				array_push($arrMsgErr, "Nama wajib Di isi");


			$this->session->set_flashdata('arrMsgErr', $arrMsgErr);
			//validate form
			if (empty(count($arrMsgErr)))
				switch ($_POST['action']) {
					case 'add':
						$refkey = $this->insert($tableName, $this->dataForm($formData));
						$this->insertDetail($tableDetail, $formDetail, $refkey);
						redirect(base_url($baseUrl . 'List')); //wajib terakhir
						break;
					case 'update':
						$this->update($tableName, $this->dataForm($formData), array('pkey' => $_POST['pkey']));
						$this->updateDetail($tableDetail, $formDetail, $detailRef, $id);
						redirect(base_url($baseUrl . 'List'));
						break;
				}
		}

		if (!empty($id)) {
			$dataRow = $this->getDataRow($tableName, '*', array('pkey' => $id), 1)[0];
			$this->dataFormEdit($formData, $dataRow);
		}

		$data['html']['baseUrl'] = $baseUrl;
		$data['html']['title'] = 'Input Data Kondisi Barang';
		$data['html']['err'] = $this->genrateErr();
		$data['url'] = 'admin/' . __FUNCTION__ . 'Form';
		$this->template($data);
	}

	public function itemList()
	{
		$tableName = 'item';

		$join = array(
			array('account', 'account.pkey=' . $tableName . '.createon', 'left'),
			array('role', 'role.pkey=account.role', 'left'),
			array('itemtype', 'itemtype.pkey=' . $tableName . '.typekey', 'left'),
		);
		$select = '
			' . $tableName . '.*,
			account.name as createname,
			account.role as createrole,
			role.name as rolename,
			itemtype.name as typename,
		';

		$dataList = $this->getDataRow($tableName, $select, '', '', $join);
		$data['html']['title'] = 'List Barang';
		$data['html']['dataList'] = $dataList;
		$data['html']['tableName'] = $tableName;
		$data['html']['form'] = get_class($this) . '/item';
		$data['url'] = 'admin/itemList';
		$this->template($data);
	}

	public function item($id = '')
	{
		$tableName = 'item';
		$tableDetail = '';
		$baseUrl = get_class($this) . '/' . __FUNCTION__;
		$detailRef = '';
		$formData = array(
			'pkey' => 'pkey',
			'name' => 'name',
			'typekey' => 'itemTypeKey',
			'createon' => 'sesionid',
			'time' => 'time',
			'unitname' => 'unitname',
		);
		$formDetail = array();

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (empty($_POST['action'])) redirect(base_url($baseUrl . 'List'));
			//validate form
			$arrMsgErr = array();
			if (empty($_POST['name']))
				array_push($arrMsgErr, "Nama wajib Di isi");
			if (empty($_POST['itemTypeKey']))
				array_push($arrMsgErr, "Type Barang wajib Di isi");


			$this->session->set_flashdata('arrMsgErr', $arrMsgErr);
			//validate form
			if (empty(count($arrMsgErr)))
				switch ($_POST['action']) {
					case 'add':
						$refkey = $this->insert($tableName, $this->dataForm($formData));
						$this->insertDetail($tableDetail, $formDetail, $refkey);
						redirect(base_url($baseUrl . 'List')); //wajib terakhir
						break;
					case 'update':
						$this->update($tableName, $this->dataForm($formData), array('pkey' => $_POST['pkey']));
						$this->updateDetail($tableDetail, $formDetail, $detailRef, $id);
						redirect(base_url($baseUrl . 'List'));
						break;
				}
		}

		if (!empty($id)) {
			$dataRow = $this->getDataRow($tableName, '*', array('pkey' => $id), 1)[0];
			$this->dataFormEdit($formData, $dataRow);
		}
		$itemType = $this->getDataRow('itemtype', '*', array('status' => 1));

		$data['html']['itemType'] = $itemType;
		$data['html']['baseUrl'] = $baseUrl;
		$data['html']['title'] = 'Input Data Barang';
		$data['html']['err'] = $this->genrateErr();
		$data['url'] = 'admin/' . __FUNCTION__ . 'Form';
		$this->template($data);
	}

	public function itemInList()
	{
		$tableName = 'itemin';

		$join = array(
			array('account', 'account.pkey=' . $tableName . '.createon', 'left'),
			array('role', 'role.pkey=account.role', 'left'),
			array('item', 'item.pkey=' . $tableName . '.itemkey', 'left'),
			array('itemtype', 'itemtype.pkey=item.typekey', 'left'),
			array('worker', 'worker.pkey=' . $tableName . '.workerkey', 'left'),
			array('team', 'team.pkey=' . $tableName . '.teamkey', 'left'),
		);
		$select = '
			' . $tableName . '.*,
			account.name as createname,
			account.role as createrole,
			role.name as rolename,
			item.name as itemname,
			itemtype.name as itemtypename,
			worker.name as workername,
			team.name as teamname,
		';

		$dataList = $this->getDataRow($tableName, $select, '', '', $join);
		$data['html']['title'] = 'List Barang Masuk';
		$data['html']['dataList'] = $dataList;
		$data['html']['tableName'] = $tableName;
		$data['html']['form'] = get_class($this) . '/itemIn';
		$data['url'] = 'admin/itemInList';
		$this->template($data);
	}
	public function itemIn($id = '')
	{
		$tableName = 'itemin';
		$tableDetail = '';
		$baseUrl = get_class($this) . '/' . __FUNCTION__;
		$detailRef = '';
		$formData = array(
			'pkey' => 'pkey',
			'itemkey' => 'itemKey',
			'count' => 'count',
			'createon' => 'sesionid',
			'time' => 'time',
			'note' => 'note',
			'workerkey' => 'workerKey',
			'teamkey' => 'teamKey',
		);
		$formDetail = array();
		$itemTable = 'item';
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (empty($_POST['action'])) redirect(base_url($baseUrl . 'List'));
			//validate form
			$arrMsgErr = array();
			if (empty($_POST['count']))
				array_push($arrMsgErr, "Jumlah wajib Di isi");
			if (empty($_POST['itemKey']))
				array_push($arrMsgErr, "Nama Barang wajib Di isi");
			if (empty($_POST['workerKey']))
				array_push($arrMsgErr, "Nama Teknisi wajib Di isi");
			if (empty($_POST['teamKey']))
				array_push($arrMsgErr, "Nama Team wajib Di isi");


			$this->session->set_flashdata('arrMsgErr', $arrMsgErr);
			//validate form
			if (empty(count($arrMsgErr)))
				switch ($_POST['action']) {
					case 'add':
						$refkey = $this->insert($tableName, $this->dataForm($formData));
						$this->insertDetail($tableDetail, $formDetail, $refkey);
						$item = $this->getDataRow($itemTable, 'stock', array('pkey' => $_POST['itemKey']))[0];
						$item['stock'] = $item['stock'] + $_POST['count'];
						$this->update($itemTable, array('stock' => $item['stock']), array('pkey' => $_POST['itemKey']));
						//chek Item /pembuatan Log
						$joinItem = array(
							array('itemtype', 'itemtype.pkey=' . $itemTable . '.typekey', 'left'),
						);
						$selectitem = $itemTable . '.*,
						itemtype.name as typename';
						$item = $this->getDataRow($itemTable, $selectitem, array($itemTable . '.pkey' => $_POST['itemKey']), '', $joinItem)[0];
						//tambah logs
						$account = $this->getDataRow('account', '*', array('pkey' => $this->id))[0];
						$logs = array(
							'name' => 'barang masuk',
							'log' => $account['name'] . ' melakukan input barang masuk ' . $item['name'] . '_' . $item['typename'] . ' sebanyak :' . $_POST['count'] . ' ' . $item['unitname'],
							'time' => strtotime('now'),
						);
						$this->insert('logs', $logs);


						redirect(base_url($baseUrl . 'List')); //wajib terakhir
						break;
					case 'update':
						$dataEdit = $this->getDataRow($tableName, 'count,itemkey,status', array('pkey' => $_POST['pkey']))[0];
						if ($dataEdit['status'] == 1)
							redirect(base_url($baseUrl . 'List'));
						//pembuatan logs
						$joinItem = array(
							array('itemtype', 'itemtype.pkey=' . $itemTable . '.typekey', 'left'),
						);
						$selectitem = $itemTable . '.*,
						itemtype.name as typename';
						$item = $this->getDataRow($itemTable, $selectitem, array($itemTable . '.pkey' => $dataEdit['itemkey']), '', $joinItem)[0];
						$account = $this->getDataRow('account', 'name', array('pkey' => $this->id))[0];
						$logs = array(
							'name' => 'barang masuk',
							'log' => $account['name'] . ' melakukan perubahan barang masuk tanggal ' . date('d/m/Y H:i', $item['time']) . ' ' . $item['name'] . '_' . $item['typename'] . ' Id_Transaksi :' . $_POST['pkey'],
							'time' => strtotime('now'),
						);
						$this->insert('logs', $logs);

						//kebalikan dulu stock
						$item = $this->getDataRow($itemTable, 'stock', array('pkey' => $dataEdit['itemkey']))[0];
						$item['stock'] = $item['stock'] - $dataEdit['count'];
						$this->update($itemTable, array('stock' => $item['stock']), array('pkey' => $dataEdit['itemkey']));
						//update ulang stock
						$item = $this->getDataRow($itemTable, 'stock', array('pkey' => $_POST['itemKey']))[0];
						$item['stock'] = $item['stock'] + $_POST['count'];
						$this->update($itemTable, array('stock' => $item['stock']), array('pkey' => $_POST['itemKey']));

						$this->update($tableName, $this->dataForm($formData), array('pkey' => $_POST['pkey']));
						$this->updateDetail($tableDetail, $formDetail, $detailRef, $id);

						redirect(base_url($baseUrl . 'List'));
						break;
				}
		}

		if (!empty($id)) {
			$dataRow = $this->getDataRow($tableName, '*', array('pkey' => $id), 1)[0];
			$this->dataFormEdit($formData, $dataRow);
		}
		//item
		$itemSelect = $itemTable . '.*,
		itemtype.name itemtypename
		';
		$itemJoint = array(
			array('itemtype', 'itemtype.pkey=' . $itemTable . '.typekey', 'left'),
		);
		$item = $this->getDataRow('item', $itemSelect, '', '', $itemJoint);
		//item 


		$worker = $this->getDataRow('worker', 'pkey,name');
		$team = $this->getDataRow('team', 'pkey,name');


		$data['html']['team'] = $team;
		$data['html']['worker'] = $worker;
		$data['html']['item'] = $item;
		$data['html']['baseUrl'] = $baseUrl;
		$data['html']['title'] = 'Input Data Barang';
		$data['html']['err'] = $this->genrateErr();
		$data['url'] = 'admin/' . __FUNCTION__ . 'Form';
		$this->template($data);
	}

	public function itemOutList()
	{
		$tableName = 'itemout';

		$join = array(
			array('account', 'account.pkey=' . $tableName . '.createon', 'left'),
			array('role', 'role.pkey=account.role', 'left'),
			array('item', 'item.pkey=' . $tableName . '.itemkey', 'left'),
			array('itemtype', 'itemtype.pkey=item.typekey', 'left'),
			array('worker', 'worker.pkey=' . $tableName . '.workerkey', 'left'),
			array('team', 'team.pkey=' . $tableName . '.teamkey', 'left'),
		);
		$select = '
			' . $tableName . '.*,
			account.name as createname,
			account.role as createrole,
			role.name as rolename,
			item.name as itemname,
			itemtype.name as itemtypename,
			worker.name as workername,
			team.name as teamname,
		';

		$dataList = $this->getDataRow($tableName, $select, '', '', $join);
		$data['html']['title'] = 'List Barang Keluar';
		$data['html']['dataList'] = $dataList;
		$data['html']['tableName'] = $tableName;
		$data['html']['form'] = get_class($this) . '/itemOut';
		$data['url'] = 'admin/itemOutList';
		$this->template($data);
	}
	public function itemOut($id = '')
	{
		$tableName = 'itemOut';
		$tableDetail = '';
		$baseUrl = get_class($this) . '/' . __FUNCTION__;
		$detailRef = '';
		$formData = array(
			'pkey' => 'pkey',
			'itemkey' => 'itemKey',
			'count' => 'count',
			'createon' => 'sesionid',
			'time' => 'time',
			'note' => 'note',
			'workerkey' => 'workerKey',
			'teamkey' => 'teamKey',
		);
		$formDetail = array();
		$itemTable = 'item';
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (empty($_POST['action'])) redirect(base_url($baseUrl . 'List'));
			//validate form
			$arrMsgErr = array();
			if (empty($_POST['count']))
				array_push($arrMsgErr, "Jumlah wajib Di isi");
			if (empty($_POST['itemKey']))
				array_push($arrMsgErr, "Nama Barang wajib Di isi");
			if (empty($_POST['workerKey']))
				array_push($arrMsgErr, "Nama Teknisi wajib Di isi");
			if (empty($_POST['teamKey']))
				array_push($arrMsgErr, "Nama Team wajib Di isi");

			$item = $this->getDataRow($itemTable, 'stock', array('pkey' => $_POST['itemKey']))[0];
			if ($item['stock'] < $_POST['count'])
				array_push($arrMsgErr, "Stock barang Tidak Mencukupi : " . $item['stock']);

			$this->session->set_flashdata('arrMsgErr', $arrMsgErr);
			//validate form
			if (empty(count($arrMsgErr)))
				switch ($_POST['action']) {
					case 'add':
						$refkey = $this->insert($tableName, $this->dataForm($formData));
						$this->insertDetail($tableDetail, $formDetail, $refkey);
						//chek Item
						$joinItem = array(
							array('itemtype', 'itemtype.pkey=' . $itemTable . '.typekey', 'left'),
						);
						$selectitem = $itemTable . '.*,
						itemtype.name as typename';

						$item = $this->getDataRow($itemTable, $selectitem, array($itemTable . '.pkey' => $_POST['itemKey']), '', $joinItem)[0];
						$item['stock'] = $item['stock'] - $_POST['count'];
						$this->update($itemTable, array('stock' => $item['stock']), array('pkey' => $_POST['itemKey']));
						//tambah logs
						$account = $this->getDataRow('account', '*', array('pkey' => $this->id))[0];
						$logs = array(
							'name' => 'barang keluar',
							'log' => $account['name'] . ' melakukan pengeluaran barang ' . $item['name'] . '_' . $item['typename'] . ' sebanyak :' . $_POST['count'],
							'time' => strtotime('now'),
						);
						$this->insert('logs', $logs);

						redirect(base_url($baseUrl . 'List')); //wajib terakhir
						break;
					case 'update':
						$dataEdit = $this->getDataRow($tableName, 'count,itemkey', array('pkey' => $_POST['pkey']))[0];
						//jika telah di closing
						if ($dataEdit['status'] == 1)
							redirect(base_url($baseUrl . 'List'));
						//pembuatan logs
						$joinItem = array(
							array('itemtype', 'itemtype.pkey=' . $itemTable . '.typekey', 'left'),
						);
						$selectitem = $itemTable . '.*
						,itemtype.name as typename';
						$item = $this->getDataRow($itemTable, $selectitem, array($itemTable . '.pkey' => $dataEdit['itemkey']), '', $joinItem)[0];
						$account = $this->getDataRow('account', 'name', array('pkey' => $this->id))[0];
						$logs = array(
							'name' => 'barang keluar',
							'log' => $account['name'] . ' melakukan perubahan barang keluar tanggal ' . date('d/m/Y H:i', $item['time']) . ' ' . $item['name'] . '_' . $item['typename'] . ' Id_Transaksi :' . $item['pkey'], ' ' . $item['unitname'],
							'time' => strtotime('now'),
						);
						$this->insert('logs', $logs);

						//kebalikan dulu stock
						$item['stock'] = $item['stock'] + $dataEdit['count'];
						$this->update($itemTable, array('stock' => $item['stock']), array('pkey' => $dataEdit['itemkey']));

						$this->update($itemTable, array('stock' => $item['stock']), array('pkey' => $_POST['itemKey']));
						$this->update($tableName, $this->dataForm($formData), array('pkey' => $_POST['pkey']));
						$this->updateDetail($tableDetail, $formDetail, $detailRef, $id);

						//update ulang stock
						$item = $this->getDataRow($itemTable, 'stock', array('pkey' => $_POST['itemKey']))[0];
						$item['stock'] = $item['stock'] - $_POST['count'];
						$this->update($itemTable, array('stock' => $item['stock']), array('pkey' => $_POST['itemKey']));

						redirect(base_url($baseUrl . 'List'));
						break;
				}
		}

		if (!empty($id)) {
			$dataRow = $this->getDataRow($tableName, '*', array('pkey' => $id), 1)[0];
			$this->dataFormEdit($formData, $dataRow);
		}
		//item

		$itemSelect = $itemTable . '.*,
		itemtype.name itemtypename
		';
		$itemJoint = array(
			array('itemtype', 'itemtype.pkey=' . $itemTable . '.typekey', 'left'),
		);
		$item = $this->getDataRow('item', $itemSelect, '', '', $itemJoint);
		//item 

		$worker = $this->getDataRow('worker', 'pkey,name');
		$team = $this->getDataRow('team', 'pkey,name');

		$data['html']['team'] = $team;
		$data['html']['worker'] = $worker;

		$data['html']['item'] = $item;
		$data['html']['baseUrl'] = $baseUrl;
		$data['html']['title'] = 'Input Data Barang Keluar';
		$data['html']['err'] = $this->genrateErr();
		$data['url'] = 'admin/' . __FUNCTION__ . 'Form';
		$this->template($data);
	}
	public function workerList()
	{
		$tableName = 'worker';

		$join = array(
			array('account', 'account.pkey=' . $tableName . '.createon', 'left'),
			array('role', 'role.pkey=account.role', 'left'),

		);
		$select = '
			' . $tableName . '.*,
			account.name as createname,
			account.role as createrole,
			role.name as rolename,
		';

		$dataList = $this->getDataRow($tableName, $select, '', '', $join);
		$data['html']['title'] = 'List Teknisi';
		$data['html']['dataList'] = $dataList;
		$data['html']['tableName'] = $tableName;
		$data['html']['form'] = get_class($this) . '/worker';
		$data['url'] = 'admin/workerList';
		$this->template($data);
	}

	public function worker($id = '')
	{
		$tableName = 'worker';
		$tableDetail = '';
		$baseUrl = get_class($this) . '/' . __FUNCTION__;
		$detailRef = '';
		$formData = array(
			'pkey' => 'pkey',
			'name' => 'name',
			'createon' => 'sesionid',
			'time' => 'time',
		);
		$formDetail = array();
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (empty($_POST['action'])) redirect(base_url($baseUrl . 'List'));
			//validate form
			$arrMsgErr = array();
			if (empty($_POST['name']))
				array_push($arrMsgErr, "Nama wajib Di isi");

			$this->session->set_flashdata('arrMsgErr', $arrMsgErr);
			//validate form
			if (empty(count($arrMsgErr)))
				switch ($_POST['action']) {
					case 'add':
						$refkey = $this->insert($tableName, $this->dataForm($formData));
						$this->insertDetail($tableDetail, $formDetail, $refkey);
						//tambah logs
						$account = $this->getDataRow('account', '*', array('pkey' => $this->id))[0];
						$logs = array(
							'name' => 'Teknisi',
							'log' => $account['name'] . ' Menambah teknisi ' . $_POST['name'],
							'time' => strtotime('now'),
						);
						$this->insert('logs', $logs);
						redirect(base_url($baseUrl . 'List')); //wajib terakhir
						break;
					case 'update':
						$this->update($tableName, $this->dataForm($formData), array('pkey' => $_POST['pkey']));
						$this->updateDetail($tableDetail, $formDetail, $detailRef, $id);
						//tambah logs
						$dataEdit = $this->getDataRow($tableName, 'name', array('pkey' => $_POST['pkey']))[0];
						$account = $this->getDataRow('account', '*', array('pkey' => $this->id))[0];
						$logs = array(
							'name' => 'Teknisi',
							'log' => $account['name'] . ' mengubah ' . $dataEdit['name'] . ' menjadi ' . $_POST['name'],
							'time' => strtotime('now'),
						);
						$this->insert('logs', $logs);

						redirect(base_url($baseUrl . 'List'));
						break;
				}
		}

		if (!empty($id)) {
			$dataRow = $this->getDataRow($tableName, '*', array('pkey' => $id), 1)[0];
			$this->dataFormEdit($formData, $dataRow);
		}



		$data['html']['baseUrl'] = $baseUrl;
		$data['html']['title'] = 'Input Teknisi';
		$data['html']['err'] = $this->genrateErr();
		$data['url'] = 'admin/' . __FUNCTION__ . 'Form';
		$this->template($data);
	}
	public function teamList()
	{
		$tableName = 'team';

		$join = array(
			array('account', 'account.pkey=' . $tableName . '.createon', 'left'),
			array('role', 'role.pkey=account.role', 'left'),

		);
		$select = '
			' . $tableName . '.*,
			account.name as createname,
			account.role as createrole,
			role.name as rolename,
		';

		$dataList = $this->getDataRow($tableName, $select, '', '', $join);
		$data['html']['title'] = 'List Team';
		$data['html']['dataList'] = $dataList;
		$data['html']['tableName'] = $tableName;
		$data['html']['form'] = get_class($this) . '/team';
		$data['url'] = 'admin/teamList';
		$this->template($data);
	}
	public function team($id = '')
	{
		$tableName = 'team';
		$tableDetail = '';
		$baseUrl = get_class($this) . '/' . __FUNCTION__;
		$detailRef = '';
		$formData = array(
			'pkey' => 'pkey',
			'name' => 'name',
			'createon' => 'sesionid',
			'time' => 'time',
		);
		$formDetail = array();
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (empty($_POST['action'])) redirect(base_url($baseUrl . 'List'));
			//validate form
			$arrMsgErr = array();
			if (empty($_POST['name']))
				array_push($arrMsgErr, "Nama wajib Di isi");

			$this->session->set_flashdata('arrMsgErr', $arrMsgErr);
			//validate form
			if (empty(count($arrMsgErr)))
				switch ($_POST['action']) {
					case 'add':
						$refkey = $this->insert($tableName, $this->dataForm($formData));
						$this->insertDetail($tableDetail, $formDetail, $refkey);
						//tambah logs
						$account = $this->getDataRow('account', '*', array('pkey' => $this->id))[0];
						$logs = array(
							'name' => 'Team',
							'log' => $account['name'] . ' Menambah team ' . $_POST['name'],
							'time' => strtotime('now'),
						);
						$this->insert('logs', $logs);
						redirect(base_url($baseUrl . 'List')); //wajib terakhir
						break;
					case 'update':
						$this->update($tableName, $this->dataForm($formData), array('pkey' => $_POST['pkey']));
						$this->updateDetail($tableDetail, $formDetail, $detailRef, $id);
						//tambah logs
						$dataEdit = $this->getDataRow($tableName, 'name', array('pkey' => $_POST['pkey']))[0];
						$account = $this->getDataRow('account', '*', array('pkey' => $this->id))[0];
						$logs = array(
							'name' => 'Team',
							'log' => $account['name'] . ' mengubah Team ' . $dataEdit['name'] . ' menjadi ' . $_POST['name'],
							'time' => strtotime('now'),
						);
						$this->insert('logs', $logs);

						redirect(base_url($baseUrl . 'List'));
						break;
				}
		}

		if (!empty($id)) {
			$dataRow = $this->getDataRow($tableName, '*', array('pkey' => $id), 1)[0];
			$this->dataFormEdit($formData, $dataRow);
		}

		$data['html']['baseUrl'] = $baseUrl;
		$data['html']['title'] = 'Input Team';
		$data['html']['err'] = $this->genrateErr();
		$data['url'] = 'admin/' . __FUNCTION__ . 'Form';
		$this->template($data);
	}


	public function closingList()
	{
		$tableName = 'close';

		$join = array(
			array('item', 'item.pkey=' . $tableName . '.itemkey', 'left'),
			array('itemtype', 'itemtype.pkey=item.typekey', 'left'),
		);
		$select = '
			' . $tableName . '.*,
			item.name as itemname,
			item.unitname as unitname,
			itemtype.name as typename,
		';
		$dataList = $this->getDataRow($tableName, $select, '', '', $join);
		$data['html']['title'] = 'List Closing';
		$data['html']['dataList'] = $dataList;
		$data['html']['tableName'] = $tableName;
		// $data['html']['form'] = get_class($this) . '/itemOut';
		$data['url'] = 'admin/closingList';
		$this->template($data);
	}
	public function logsList()
	{
		$tableName = 'logs';

		$dataList = $this->getDataRow($tableName, '*');
		$data['html']['title'] = 'List Logs';
		$data['html']['dataList'] = $dataList;
		$data['html']['tableName'] = $tableName;
		// $data['html']['form'] = get_class($this) . '/itemOut';
		$data['url'] = 'admin/logsList';
		$this->template($data);
	}







	public function userList()
	{
		if ($this->session->userdata('role') != '1')
			redirect(base_url());
		$tableName = 'account';
		$join = array(
			array('role', 'role.pkey=account.role', 'left'),
		);
		$dataList = $this->getDataRow($tableName, 'account.*, role.name as rolename', '', '', $join, 'name ASC');
		$data['html']['title'] = 'List Account';
		$data['html']['dataList'] = $dataList;
		$data['html']['tableName'] = $tableName;
		$data['html']['form'] = get_class($this) . '/user';
		$data['url'] = 'admin/userList';
		$this->template($data);
	}

	public function user($id = '')
	{
		$tableName = 'account';
		$tableDetail = '';
		$baseUrl = get_class($this) . '/' . __FUNCTION__;
		$detailRef = '';
		$formData = array(
			'pkey' => 'pkey',
			'name' => 'name',
			'username' => 'username',
			'role' => 'role',
		);
		$formDetail = array();

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (empty($_POST['action'])) redirect(base_url($baseUrl . 'List'));
			//validate form
			$arrMsgErr = array();
			if (empty($_POST['name']))
				array_push($arrMsgErr, "Password wajib Di isi");

			if (empty($_POST['password']) && $_POST['action'] == 'add')
				array_push($arrMsgErr, "Password wajib Di isi");
			if ($_POST['role'] == '1')
				unset($_POST['detailKey']);



			$this->session->set_flashdata('arrMsgErr', $arrMsgErr);
			//validate form
			if (empty(count($arrMsgErr)))
				switch ($_POST['action']) {
					case 'add':
						$formData['password'] = array('password', 'md5');
						$refkey = $this->insert($tableName, $this->dataForm($formData));
						$this->insertDetail($tableDetail, $formDetail, $refkey);
						redirect(base_url($baseUrl . 'List')); //wajib terakhir
						break;
					case 'update':
						if (!empty($_POST['password']))
							$formData['password'] = array('password', 'md5');
						$this->update($tableName, $this->dataForm($formData), array('pkey' => $_POST['pkey']));
						$this->updateDetail($tableDetail, $formDetail, $detailRef, $id);
						redirect(base_url($baseUrl . 'List'));
						break;
				}
		}

		if (!empty($id)) {
			$dataRow = $this->getDataRow($tableName, '*', array('pkey' => $id), 1)[0];
			$this->dataFormEdit($formData, $dataRow);
			$_POST['password'] = '';
		}
		$selVal = $this->getDataRow('role', '*', '', '', '', 'name ASC');
		$selValClass = $this->getDataRow('class', '*', '', '', '', 'name ASC');

		$data['html']['selValClass'] = $selValClass;
		$data['html']['baseUrl'] = $baseUrl;
		$data['html']['selVal'] = $selVal;
		$data['html']['title'] = 'Input Data ' . __FUNCTION__;
		$data['html']['err'] = $this->genrateErr();
		$data['url'] = 'admin/' . __FUNCTION__ . 'Form';
		$this->template($data);
	}

	public function ajax()
	{
		if (empty($_POST['action'])) {
			echo 'no action';
			die;
		}
		switch ($_POST['action']) {
			case 'delete':
				switch ($_POST['tbl']) {
					case 'itemin':
						$itemIn = $this->getDataRow($_POST['tbl'], '*', array('pkey' => $_POST['pkey']))[0];
						if ($itemIn['status'] == 1)
							die;
						$item = $this->getDataRow('item', 'stock,name,typekey', array('pkey' => $itemIn['itemkey']))[0];
						$itemType = $this->getDataRow('itemtype', 'name', array('pkey' => $item['typekey']))[0];
						//pembuatan log 
						$account = $this->getDataRow('account', 'name', array('pkey' => $this->id))[0];
						$logs = array(
							'name' => 'barang masuk',
							'log' => $account['name'] . ' melakukan penghapusan barang masuk dengan data : ' . $item['name'] . '_' . $itemType['name'] . ' jumlah_barang : ' . $itemIn['count'] . ' Catatan :' . $itemIn['note'] . ' Tanggal : ' . date('d/m/Y H:i', $itemIn['time']),
							'time' => strtotime('now'),
						);
						$this->insert('logs', $logs);
						$item['stock'] = $item['stock'] - $itemIn['count'];
						$this->update('item', array('stock' => $item['stock']), array('pkey' => $itemIn['itemkey']));
						$this->delete($_POST['tbl'], 'pkey=' . $_POST['pkey']);
						break;
					case 'itemout':
						$itemOut = $this->getDataRow($_POST['tbl'], '*', array('pkey' => $_POST['pkey']))[0];
						if ($itemOut['status'] == 1)
							die;
						$item = $this->getDataRow('item', 'stock,name,typekey', array('pkey' => $itemOut['itemkey']))[0];
						$itemType = $this->getDataRow('itemtype', 'name', array('pkey' => $item['typekey']))[0];
						//pembuatan log 
						$account = $this->getDataRow('account', 'name', array('pkey' => $this->id))[0];
						$logs = array(
							'name' => 'barang keluar',
							'log' => $account['name'] . ' melakukan penghapusan barang keluar dengan data : ' . $item['name'] . '_' . $itemType['name'] . ' jumlah_barang : ' . $itemOut['count'] . ' Catatan :' . $itemOut['note'] . ' Tanggal : ' . date('d/m/Y H:i', $itemOut['time']),
							'time' => strtotime('now'),
						);
						$this->insert('logs', $logs);
						$item['stock'] = $item['stock'] + $itemOut['count'];
						$this->update('item', array('stock' => $item['stock']), array('pkey' => $itemOut['itemkey']));
						$this->delete($_POST['tbl'], 'pkey=' . $_POST['pkey']);
						break;
					default:
						$this->delete($_POST['tbl'], 'pkey=' . $_POST['pkey']);
						break;
				}
				break;
			case 'statusItemType':
				$checkdata = $this->getDataRow('itemtype', 'status', array('pkey' => $_POST['pkey']))[0];
				$status = 1;
				if ($checkdata['status'] == 1)
					$status = 0;
				$this->update('itemtype', array('status' => $status), array('pkey' => $_POST['pkey']));
				break;

				$oldststus = $this->getDataRow('content', 'status', array('pkey' => $_POST['pkey']));
				$status = '1';
				if ($oldststus[0]['status'] == '1')
					$status = '0';
				$this->update('content', array('status' => $status), array('pkey' => $_POST['pkey']));
				break;
			default:
				echo 'action is not in the list';
				break;
		}
	}
}
