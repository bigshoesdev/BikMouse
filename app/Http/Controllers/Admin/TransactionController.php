<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\JoshController;
use App\Http\Requests\TransactionRequest;
use App\Transaction;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use File;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Redirect;
use Sentinel;
use URL;
use View;
use Yajra\DataTables\DataTables;
use Validator;
use App\Mail\Restore;
use stdClass;

class TransactionController extends JoshController
{
    /**
     * Show a list of all the users.
     *
     * @return View
     */

    public function index()
    {
        $transactions = Transaction::orderby('created_at', 'desc')->get();

        // Show the page
        return view('admin.transaction.index', compact('transactions'));
    }

    public function create() {
        return view('admin.transaction.create');
    }

    public function show(Transaction $transaction)
    {
        return Redirect::route('admin.transaction.index');
    }

    public function store(TransactionRequest $request) {

        $Transaction = new Transaction($request->only(['broadcast_id', 'amount']));

        if ($Transaction->save()) {
            return redirect('admin/transaction')->with('success', trans('transaction/message.success.create'));
        } else {
            return Redirect::route('admin/transaction')->withInput()->with('error', trans('transaction/message.error.create'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Transaction $transaction
     * @return view
     */
    public function edit(Transaction $transaction)
    {
        return view('admin.transaction.edit', compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Transaction $transaction
     * @return Response
     */
    public function update(TransactionRequest $request, Transaction $transaction)
    {

        if ($transaction->update($request->only(['broadcast_id', 'amount']))) {
            return redirect('admin/transaction')->with('success', trans('message.success.update'));
        } else {
            return redirect('admin/transaction')->withInput()->with('error', trans('message.error.update'));
        }
    }

    public function destroy(Transaction $transaction) {
        if ($transaction->update(['status' => 0])) {
            return redirect('admin/transaction')->with('success', trans('transaction/message.success.delete'));
        } else {
            return Redirect::route('admin/transaction')->withInput()->with('error', trans('transaction/message.error.delete'));
        }
    }

    public function getModalDelete(Transaction $transaction)
    {
        $model = 'transaction';
        $confirm_route = $error = null;
        try {
            $confirm_route = route('admin.transaction.delete', ['id' => $transaction->id]);
            return view('admin.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
        } catch (GroupNotFoundException $e) {

            $error = trans('transaction/message.error.delete', compact('id'));
            return view('admin.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
        }
    }
}
