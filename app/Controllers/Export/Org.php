<?php

namespace App\Controllers\Export;

use App\Controllers\BaseController;
use App\Libraries\Auth;
use App\Models\OrganizationModel;
use App\Models\OrganizationMemberModel;
use App\Models\PertemuanModel;
use App\Models\TagihanModel;
use App\Models\TransaksiModel;
use App\Models\KasModel;

use Dompdf\Dompdf;
use Dompdf\Options;

class Org extends BaseController
{
    public function members($format, $organization_id)
    {
        $auth = new Auth();
        if(!$auth->isLogin()) return redirect()->to('login');

        $orgModel = new OrganizationModel();
        $organization = $orgModel->find($organization_id);

        $orgMemberModel = new OrganizationMemberModel();
        $orgMemberModel->where('organization_member.organization_id', $organization_id);
        $orgMemberModel->where('organization_member.status', 'verified');
        $members = $orgMemberModel->findAll();

        $data['org'] = $organization;
        $data['members'] = $members;

        if($format == 'print'){
            $data['is_print'] = true;
            return view('export/org/members', $data);
        }

        if($format == 'pdf'){
            $html = view('export/org/members', $data);
            $options = new Options();
            $options->setDefaultFont('times-roman');

            $dompdf = new Dompdf($options);
            $dompdf->setPaper('A4', 'potrait');
            $dompdf->loadHtml($html);
            $dompdf->render();
            $dompdf->stream('Laporan Anggota '.$organization['title'], [ 'Attachment' => false ]);
        }

        if($format == 'excel'){
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Laporan Anggota ".$organization['title'].".xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            return view('export/org/members', $data);
        }

        return 'Format tidak didukung!';
    }

    public function absensi($format, $id)
    {
        $auth = new Auth();
        if(!$auth->isLogin()) return redirect()->to('login');

        $pertemuanModel = new PertemuanModel();
        $pertemuan = $pertemuanModel->find($id);

        $memberModel = new OrganizationMemberModel();
        $memberModel->select("IFNULL((SELECT presensi.status FROM presensi WHERE presensi.pertemuan_id = '$id' AND presensi.member_id = organization_member.id), '-') as presensi_status");
        $memberModel->where('organization_member.organization_id', $pertemuan['organization_id']);
        $memberModel->where('organization_member.status', 'verified');
        $data['members'] = $memberModel->findAll();
        $data['pertemuan'] = $pertemuan;

        if($format == 'print'){
            $data['is_print'] = true;
            return view('export/org/absensi', $data);
        }

        if($format == 'pdf'){
            $html = view('export/org/absensi', $data);
            $options = new Options();
            $options->setDefaultFont('times-roman');

            $dompdf = new Dompdf($options);
            $dompdf->setPaper('A4', 'potrait');
            $dompdf->loadHtml($html);
            $dompdf->render();
            $dompdf->stream('Laporan Anggota '.$pertemuan['title'], [ 'Attachment' => false ]);
        }

        if($format == 'excel'){
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Laporan Absensi ".$pertemuan['title'].".xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            return view('export/org/absensi', $data);
        }

        return 'Format tidak didukung!';
    }

    public function tagihan($format, $id)
    {
        $auth = new Auth();
        if(!$auth->isLogin()) return redirect()->to('login');

        $tagihanId = $id;
        $tagihanModel = new TagihanModel();
        $tagihan = $tagihanModel->find($tagihanId);

        $memberModel = new OrganizationMemberModel();
        $memberModel->select("IFNULL((SELECT transaksi.status FROM transaksi WHERE transaksi.tagihan_id = '$tagihanId' AND transaksi.member_id = organization_member.id), 'Unpaid') as transaction_status");
        $memberModel->select("IFNULL((SELECT transaksi.amount FROM transaksi WHERE transaksi.tagihan_id = '$tagihanId' AND transaksi.member_id = organization_member.id), '0') as amount_paid");
        $memberModel->where('organization_member.organization_id', $tagihan['organization_id']);
        $memberModel->where('organization_member.status', 'verified');
        $members = $memberModel->findAll();

        $data['tagihan'] = $tagihan;
        $data['members'] = $members;

        if($format == 'print'){
            $data['is_print'] = true;
            return view('export/org/tagihan', $data);
        }

        if($format == 'pdf'){
            $html = view('export/org/tagihan', $data);
            $options = new Options();
            $options->setDefaultFont('times-roman');

            $dompdf = new Dompdf($options);
            $dompdf->setPaper('A4', 'potrait');
            $dompdf->loadHtml($html);
            $dompdf->render();
            $dompdf->stream('Laporan '.$tagihan['title'], [ 'Attachment' => false ]);
        }

        if($format == 'excel'){
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Laporan ".$tagihan['title'].".xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            return view('export/org/tagihan', $data);
        }

        return 'Format tidak didukung!';
    }
}
