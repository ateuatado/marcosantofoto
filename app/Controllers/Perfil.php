<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Perfil extends BaseController
{
    /**
     * Formulário de troca de senha
     *
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     */
    public function trocar_senha()
    {
        if (! auth()->loggedIn()) {
            return redirect()->to('login');
        }

        return view('perfil/trocar_senha');
    }

    /**
     * Processa a troca de senha
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function salvar_senha()
    {
        if (! auth()->loggedIn()) {
            return redirect()->to('login');
        }

        $nova = $this->request->getPost('nova_senha');
        $conf = $this->request->getPost('confirmar_senha');

        if (empty($nova) || strlen($nova) < 8) {
            return redirect()->back()->with('erro', 'A senha deve ter ao menos 8 caracteres.');
        }

        if ($nova !== $conf) {
            return redirect()->back()->with('erro', 'As senhas não conferem.');
        }

        $users = auth()->getProvider();
        $user  = $users->findById(auth()->id());
        $user->password = $nova;

        if (! $users->save($user)) {
            return redirect()->back()->with('erro', 'Não foi possível salvar a nova senha.');
        }

        return redirect()->to('ensaios')->with('sucesso', 'Senha alterada com sucesso!');
    }
}
