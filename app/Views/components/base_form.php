<?php

/**
 * Base Form Component (RESTful-ready)
 *
 * This component renders a reusable form in CodeIgniter 4.
 * It supports CSRF protection, RESTful HTTP methods (PUT, PATCH, DELETE), validation, and dynamic buttons.
 *
 * Parameters:
 * - $action: string, the form's action URL
 * - $method: string, form method (optional, default is 'post')
 * - $fields: array of form fields (see structure below)
 *      Each field can contain:
 *          - name: string, field name
 *          - label: string, field label
 *          - type: string, input type ('text', 'email', 'password', 'textarea', 'select', etc.)
 *          - value: string, initial value
 *          - placeholder: string (optional)
 *          - required: bool (optional)
 *          - options: array (only for 'select' type)
 * - $buttons: array of buttons (see structure below)
 *      Each button can contain:
 *          - type: 'submit' or 'link'
 *          - class: string, Bootstrap classes
 *          - icon: string (optional, e.g., 'bi bi-check-circle')
 *          - text: string, button label
 *          - url: string (only for 'link' type)
 * - $validation: CI4 validation object (optional)
 * - $restMethod: string, HTTP method for RESTful forms (POST, PUT, PATCH, DELETE). Default: 'POST'
 */

$restMethod = strtoupper($restMethod ?? 'POST');
?>

<form action="<?= $action ?>" method="post">
    <?= csrf_field() ?>
    <?php if ($restMethod !== 'POST') : ?>
        <input type="hidden" name="_method" value="<?= $restMethod ?>">
    <?php endif; ?>

    <?php foreach ($fields as $field) : ?>
        <div class="mb-3">
            <label for="<?= $field['name'] ?>" class="form-label"><?= $field['label'] ?></label>

            <?php if (($field['type'] ?? 'text') === 'textarea') : ?>
                <textarea name="<?= $field['name'] ?>" id="<?= $field['name'] ?>" class="form-control <?= isset($validation) && $validation->hasError($field['name']) ? 'is-invalid' : '' ?>" placeholder="<?= $field['placeholder'] ?? '' ?>" <?= !empty($field['required']) ? 'required' : '' ?>><?= $field['value'] ?? '' ?></textarea>

            <?php elseif (($field['type'] ?? 'text') === 'select') : ?>
                <select name="<?= $field['name'] ?>" id="<?= $field['name'] ?>" class="form-select <?= isset($validation) && $validation->hasError($field['name']) ? 'is-invalid' : '' ?>" <?= !empty($field['required']) ? 'required' : '' ?>>
                    <?php foreach ($field['options'] as $key => $val) : ?>
                        <option value="<?= $key ?>" <?= (isset($field['value']) && $field['value'] == $key) ? 'selected' : '' ?>><?= $val ?></option>
                    <?php endforeach; ?>
                </select>

            <?php else : ?>
                <input type="<?= $field['type'] ?? 'text' ?>" name="<?= $field['name'] ?>" id="<?= $field['name'] ?>" value="<?= $field['value'] ?? '' ?>" placeholder="<?= $field['placeholder'] ?? '' ?>" class="form-control <?= isset($validation) && $validation->hasError($field['name']) ? 'is-invalid' : '' ?>" <?= !empty($field['required']) ? 'required' : '' ?>>
            <?php endif; ?>

            <?php if (isset($validation) && $validation->hasError($field['name'])) : ?>
                <div class="invalid-feedback">
                    <?= $validation->getError($field['name']) ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

    <div class="d-flex justify-content-between">
        <?php foreach ($buttons as $btn) : ?>
            <?php if ($btn['type'] == 'submit') : ?>
                <button type="submit" class="btn <?= $btn['class'] ?>">
                    <?php if (!empty($btn['icon'])) : ?><i class="<?= $btn['icon'] ?> me-1"></i><?php endif; ?><?= $btn['text'] ?>
                </button>
            <?php elseif ($btn['type'] == 'link') : ?>
                <a href="<?= $btn['url'] ?>" class="btn <?= $btn['class'] ?>">
                    <?php if (!empty($btn['icon'])) : ?><i class="<?= $btn['icon'] ?> me-1"></i><?php endif; ?><?= $btn['text'] ?>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</form>