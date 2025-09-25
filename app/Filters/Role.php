<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Role implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Get session
        $session = session();

        // Check if logged in
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        // Check role
        if ($arguments && isset($arguments[0])) {
            $requiredRole = $arguments[0]; // e.g., 'admin', 'staff', 'resident'
            $roleIdMap = [
                'resident' => 1,
                'staff'    => 2,
                'admin'    => 3,
            ];

            if (!isset($roleIdMap[$requiredRole]) || $session->get('role_id') != $roleIdMap[$requiredRole]) {

                return redirect()->to('/unauthorized');
            }
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
