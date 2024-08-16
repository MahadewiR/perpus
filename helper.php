<?php
function getStatus($status)
{
    switch ($status) {
        case '1';
            $label = '<div class="badge text-bg-primary">Sedang Dipinjam</div>';
            break;
        case '2';
            $label = '<span class="badge text-bg-success">Sudah Dikembalikan</div>';
            break;

        default;
            $label = "";
            break;
    }
    return $label;
}
