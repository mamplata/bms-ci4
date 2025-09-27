<?php

namespace App\Controllers;

use App\Models\AuditLogModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    protected $auditModel;
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        $this->auditModel = new AuditLogModel();

        // E.g.: $this->session = service('session');
    }

    /**
     * Generic DataTables server-side response
     *
     * @param \CodeIgniter\Model $model       Model instance
     * @param array $columns                  Columns allowed for sorting
     * @param array $searchable               Columns allowed for search
     * @param array $defaultOrder             Default order if none specified
     * @param array $filters                  Base filters (column => value)
     */
    protected function datatableResponse($model, array $columns, array $searchable = [], array $defaultOrder = ['created_at' => 'DESC'], array $filters = [])
    {
        $request = service('request');

        $draw   = $request->getPost('draw');
        $start  = $request->getPost('start');
        $length = $request->getPost('length');
        $search = $request->getPost('search')['value'] ?? '';
        $order  = $request->getPost('order');
        $cols   = $request->getPost('columns');

        $builder = $model;

        // Apply base filters
        foreach ($filters as $col => $val) {
            $builder->where($col, $val);
        }

        // Filtering
        if (!empty($search) && count($searchable) > 0) {
            $builder->groupStart();
            foreach ($searchable as $col) {
                $builder->orLike($col, $search);
            }
            $builder->groupEnd();
        }

        // Total & filtered count
        $recordsTotal    = $model->countAllResults(false);
        $recordsFiltered = $builder->countAllResults(false);

        // Sorting
        if (!empty($order)) {
            foreach ($order as $o) {
                $colIndex = intval($o['column']);
                $dir      = $o['dir'] === 'asc' ? 'ASC' : 'DESC';
                $colName  = $cols[$colIndex]['data'];

                if (in_array($colName, $columns)) {
                    $builder->orderBy($colName, $dir);
                }
            }
        } else {
            foreach ($defaultOrder as $col => $dir) {
                $builder->orderBy($col, $dir);
            }
        }

        // Pagination
        $data = $builder->findAll($length, $start);

        return $this->response->setJSON([
            'draw'            => intval($draw),
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $data,
            'csrf'            => [
                'token' => csrf_token(),
                'hash'  => csrf_hash()
            ]
        ]);
    }

    /**
     * Helper: log actions
     */
    protected function logAction($userId, $action)
    {

        if ($userId) {
            $this->auditModel->insert([
                'user_id'    => $userId,
                'action'     => $action,
                'ip_address' => $this->request->getIPAddress(),
                'user_agent' => $this->request->getUserAgent()->getAgentString(),
            ]);
        }
    }
}
