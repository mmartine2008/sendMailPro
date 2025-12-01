<div>
    <label class="block">Host</label>
    <input type="text" name="host" value="{{ old('host', $smtp->host ?? '') }}"
           class="w-full border p-2 rounded">
</div>

<div>
    <label class="block">SMTP Auth</label>
    <select name="smtp_auth" class="w-full border p-2 rounded">
        <option value="1" {{ old('smtp_auth', $smtp->smtp_auth ?? 1) == 1 ? 'selected' : '' }}>Sí</option>
        <option value="0" {{ old('smtp_auth', $smtp->smtp_auth ?? 1) == 0 ? 'selected' : '' }}>No</option>
    </select>
</div>

<div>
    <label class="block">Usuario</label>
    <input type="text" name="username" value="{{ old('username', $smtp->username ?? '') }}"
           class="w-full border p-2 rounded">
</div>

<div>
    <label class="block">Password</label>
    <input type="password" name="password" value="{{ old('password', $smtp->password ?? '') }}"
           class="w-full border p-2 rounded">
</div>

<div>
    <label class="block">Encriptación</label>
    <input type="text" name="encryption" value="{{ old('encryption', $smtp->encryption ?? '') }}"
           class="w-full border p-2 rounded">
</div>

<div>
    <label class="block">Puerto</label>
    <input type="number" name="port" value="{{ old('port', $smtp->port ?? 587) }}"
           class="w-full border p-2 rounded">
</div>

<div>
    <label class="block">Enviar como HTML</label>
    <select name="is_html" class="w-full border p-2 rounded">
        <option value="1" {{ old('is_html', $smtp->is_html ?? 1) == 1 ? 'selected' : '' }}>Sí</option>
        <option value="0" {{ old('is_html', $smtp->is_html ?? 1) == 0 ? 'selected' : '' }}>No</option>
    </select>
</div>
