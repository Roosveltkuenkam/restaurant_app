<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
    <div style="grid-column:1/-1;">
        <label for="profile_photo" style="display:block;font-weight:600;margin-bottom:6px;color:#333;">Photo de profil</label>
        <div style="display:flex;gap:16px;align-items:flex-start;">
            <div style="flex-shrink:0;">
                <img id="photo-preview" src="{{ $user && $user->profile_photo ? asset('storage/profile-photos/' . $user->profile_photo) : asset('images/default-avatar.svg') }}" 
                     alt="Preview" style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:2px solid #ddd;">
            </div>
            <div style="flex:1;">
                <input 
                    type="file" 
                    id="profile_photo" 
                    name="profile_photo" 
                    accept="image/*"
                    onchange="previewPhoto(this)"
                    style="width:100%;padding:8px;border:1px dashed #9BAF0A;border-radius:4px;font-size:13px;"
                />
                <small style="color:#999;display:block;margin-top:4px;">Formats: JPG, PNG. Taille max: 2MB</small>
                @error('profile_photo')
                    <small style="color:#d32f2f;display:block;margin-top:4px;">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </div>

    <div style="grid-column:1/-1;">
        <label for="name" style="display:block;font-weight:600;margin-bottom:6px;color:#333;">Nom : <span style="color:#d32f2f;">*</span></label>
        <input 
            type="text" 
            id="name" 
            name="name" 
            value="{{ old('name', $user->name ?? '') }}" 
            required 
            style="width:100%;padding:10px;border:1px solid #ddd;border-radius:4px;font-size:14px;@error('name') border-color:#d32f2f; @enderror"
        />
        @error('name')
            <small style="color:#d32f2f;display:block;margin-top:4px;">{{ $message }}</small>
        @enderror
    </div>

    <div style="grid-column:1/-1;">
        <label for="email" style="display:block;font-weight:600;margin-bottom:6px;color:#333;">Email : <span style="color:#d32f2f;">*</span></label>
        <input 
            type="email" 
            id="email" 
            name="email" 
            value="{{ old('email', $user->email ?? '') }}" 
            required 
            style="width:100%;padding:10px;border:1px solid #ddd;border-radius:4px;font-size:14px;@error('email') border-color:#d32f2f; @enderror"
        />
        @error('email')
            <small style="color:#d32f2f;display:block;margin-top:4px;">{{ $message }}</small>
        @enderror
    </div>

    <div>
        <label for="phone" style="display:block;font-weight:600;margin-bottom:6px;color:#333;">Téléphone:</label>
        <input 
            type="tel" 
            id="phone" 
            name="phone" 
            value="{{ old('phone', $user->phone ?? '') }}" 
            style="width:100%;padding:10px;border:1px solid #ddd;border-radius:4px;font-size:14px;@error('phone') border-color:#d32f2f; @enderror"
        />
        @error('phone')
            <small style="color:#d32f2f;display:block;margin-top:4px;">{{ $message }}</small>
        @enderror
    </div>

    <div>
        <label for="branch_id" style="display:block;font-weight:600;margin-bottom:6px;color:#333;">Succursale (optionnel)</label>
        <select 
            id="branch_id" 
            name="branch_id" 
            style="width:100%;padding:10px;border:1px solid #ddd;border-radius:4px;font-size:14px;"
        >
            <option value="">-- Sélectionner une succursale --</option>
            @foreach (\App\Models\Branch::all() as $branch)
                <option value="{{ $branch->id }}" @if(old('branch_id', $user->branch_id ?? null) == $branch->id) selected @endif>
                    {{ $branch->name }}
                </option>
            @endforeach
        </select>
    </div>

    @if($user)
    <div style="grid-column:1/-1;">
        <label for="password" style="display:block;font-weight:600;margin-bottom:6px;color:#333;">Mot de passe <span style="color:#999;font-weight:400;">(laisser vide pour conserver le courant)</span></label>
        <input 
            type="password" 
            id="password" 
            name="password" 
            style="width:100%;padding:10px;border:1px solid #ddd;border-radius:4px;font-size:14px;@error('password') border-color:#d32f2f; @enderror"
        />
        @error('password')
            <small style="color:#d32f2f;display:block;margin-top:4px;">{{ $message }}</small>
        @enderror
    </div>

    <div style="grid-column:1/-1;">
        <label for="password_confirmation" style="display:block;font-weight:600;margin-bottom:6px;color:#333;">Confirmer le mot de passe</label>
        <input 
            type="password" 
            id="password_confirmation" 
            name="password_confirmation" 
            style="width:100%;padding:10px;border:1px solid #ddd;border-radius:4px;font-size:14px;"
        />
    </div>
    @else
    <div style="grid-column:1/-1;background:#e8f5e9;padding:12px;border-radius:4px;border-left:4px solid #4caf50;">
        <p style="margin:0;color:#2e7d32;font-size:14px;">
            <strong>✓ Mot de passe généré automatiquement</strong><br>
            <span style="font-size:13px;color:#558b2f;">Un mot de passe temporaire sera généré et envoyé par email à l'utilisateur.</span>
        </p>
    </div>
    @endif

    <div style="grid-column:1/-1;">
        <label style="display:block;font-weight:600;margin-bottom:10px;color:#333;">Rôles</label>
        <div style="display:flex;flex-direction:column;gap:8px;">
            @forelse ($roles as $role)
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                    <input 
                        type="checkbox" 
                        name="roles[]" 
                        value="{{ $role->id }}"
                        @if(in_array($role->id, old('roles', isset($user) && $user->roles ? $user->roles->pluck('id')->toArray() : []))) checked @endif
                        style="cursor:pointer;width:16px;height:16px;"
                    />
                    <span style="color:#333;">{{ $role->name }}</span>
                </label>
            @empty
                <p style="color:#999;font-size:14px;">Aucun rôle disponible.</p>
            @endforelse
        </div>
    </div>
</div>

<script>
function previewPhoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = (e) => {
            document.getElementById('photo-preview').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
