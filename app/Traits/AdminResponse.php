<?php

namespace App\Traits;

use App\Admin\Support\Breadcrumb\Breadcrumb;
use App\Exceptions\CustomException;
use Closure;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait AdminResponse
{
    use UseLog;

    public function renderView(string $view, Breadcrumb $breadcrumbs, array $data = [])
    {
        return view($view, array_merge($data, ['breadcrumbs' => $breadcrumbs]));
    }

    public function handleStoreResponseWithCustomParam(
        $parentId,
        string $paramName,
        Request $request,
        Closure $storeFunction,
        string $indexRoute,
    ): RedirectResponse {
        DB::beginTransaction();

        try {
            $response = $storeFunction($request);

            if ($response) {
                DB::commit();
                return to_route($indexRoute, [$paramName => $parentId])->with('success', __('notifySuccess'));
            }

            DB::rollback();
            return back()->with('error', __('notifyError'))->withInput();
        } catch (Exception $e) {
            DB::rollback();
            $this->logError("Error during store or update operation", $e);
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function handleUpdateResponseWithCustomParam(
        $parentId,
        string $paramName,
        Request $request,
        Closure $updateFunction,
        string $indexRoute,
    ): RedirectResponse {
        DB::beginTransaction();

        try {
            $response = $updateFunction($request);

            if ($response) {
                DB::commit();
                return to_route($indexRoute, [$paramName => $parentId])->with('success', __('notifySuccess'));
            }

            DB::rollback();
            return back()->with('error', __('notifyFail'))->withInput();
        } catch (Exception $e) {
            DB::rollback();
            $this->logError("Error during update operation", $e);
            return back()->with('error', $e->getMessage())->withInput();
        }
    }



    public function handleDeleteResponseWithCustomParam(
        $id,
        Closure $deleteFunction,
        string $indexRoute,
        $paramaters = [],
    ): RedirectResponse {
        DB::beginTransaction();

        try {
            $response = $deleteFunction($id);

            if ($response) {
                DB::commit();
                return to_route($indexRoute, $paramaters)->with('success', __('notifySuccess'));
            }

            DB::rollback();
            return back()->with('error', __('notifyFail'));
        } catch (Exception $e) {
            DB::rollback();
            $this->logError("Error during delete operation", $e);
            return back()->with('error', __('notifyFail'));
        }
    }


    public function handleStoreResponse(Request $request, Closure $storeFunction, string $editRoute): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $response = $storeFunction($request);

            if ($response) {
                DB::commit();
                return to_route($editRoute, ['id' => $response->id])->with('success', __('notifySuccess'));
            }

            DB::rollback();
            return back()->with('error', __('notifyError'))->withInput();
        } catch (Exception $e) {
            DB::rollback();
            $this->logError("Error during store or update operation", $e);
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Generate a response for updating a resource with transaction handling.
     *
     * @param Request $request The current request instance.
     * @param Closure $updateFunction The closure function that performs the update operation.
     * @return RedirectResponse
     */
    public function handleUpdateResponse(Request $request, Closure $updateFunction): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $response = $updateFunction($request);

            if ($response) {
                DB::commit();
                return back()->with('success', __('notifySuccess'));
            }

            DB::rollback();
            return back()->with('error', __('notifyFail'))->withInput();
        } catch (Exception $e) {
            DB::rollback();
            $this->logError("Error during update operation", $e);
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Generate a response for deleting a resource with transaction handling.
     *
     * @param mixed $id The id of the resource to delete.
     * @param Closure $deleteFunction The closure function that performs the delete operation.
     * @return RedirectResponse
     */
    public function handleDeleteResponse($id, Closure $deleteFunction, string $indexRoute): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $response = $deleteFunction($id);

            if ($response) {
                DB::commit();
                return to_route($indexRoute)->with('success', __('notifySuccess'));
            }

            DB::rollback();
            return back()->with('error', __('notifyFail'));
        } catch (CustomException $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        } catch (Exception $e) {
            DB::rollback();
            $this->logError("Error during delete operation", $e);
            return back()->with('error', __('notifyFail'));
        }
    }

    public function handleStoreResponseWithOtherParam(Request $request, Closure $storeFunction, string $editRoute, $param, $value): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $response = $storeFunction($request);

            if ($response) {
                DB::commit();
                return to_route($editRoute, ['id' => $response->id, $param => $value])->with('success', __('notifySuccess'));
            }

            DB::rollback();
            return back()->with('error', __('notifyError'))->withInput();
        } catch (Exception $e) {
            DB::rollback();
            $this->logError("Error during store or update operation", $e);
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function handleDeleteResponseWithOtherParam($id, Closure $deleteFunction, string $indexRoute, $param, $value): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $response = $deleteFunction($id);

            if ($response) {
                DB::commit();
                return to_route($indexRoute, [$param => $value])->with('success', __('notifySuccess'));
            }

            DB::rollback();
            return back()->with('error', __('notifyFail'));
        } catch (CustomException $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        } catch (Exception $e) {
            DB::rollback();
            $this->logError("Error during delete operation", $e);
            return back()->with('error', __('notifyFail'));
        }
    }
}
