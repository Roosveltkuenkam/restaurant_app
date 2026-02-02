<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
    <div style="grid-column:1/-1;">
        <label for="name" style="display:block;font-weight:600;margin-bottom:6px;color:#333;">Name : <span style="color:#d32f2f;">*</span></label>
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
        <label for="phone" style="display:block;font-weight:600;margin-bottom:6px;color:#333;">Phone number:</label>
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
        <label for="branch_id" style="display:block;font-weight:600;margin-bottom:6px;color:#333;">Branch (optional)</label>
        <select 
            id="branch_id" 
            name="branch_id" 
            style="width:100%;padding:10px;border:1px solid #ddd;border-radius:4px;font-size:14px;"
        >
            <option value="">-- Select branch --</option>
            @foreach (\App\Models\Branch::all() as $branch)
                <option value="{{ $branch->id }}" @if(old('branch_id', $user->branch_id ?? null) == $branch->id) selected @endif>
                    {{ $branch->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div style="grid-column:1/-1;">
        <label for="password" style="display:block;font-weight:600;margin-bottom:6px;color:#333;">Password @if($user) <span style="color:#999;font-weight:400;">(leave blank to keep current)</span> @else <span style="color:#d32f2f;">*</span> @endif</label>
        <input 
            type="password" 
            id="password" 
            name="password" 
            @if(!$user) required @endif
            style="width:100%;padding:10px;border:1px solid #ddd;border-radius:4px;font-size:14px;@error('password') border-color:#d32f2f; @enderror"
        />
        @error('password')
            <small style="color:#d32f2f;display:block;margin-top:4px;">{{ $message }}</small>
        @enderror
    </div>

    <div style="grid-column:1/-1;">
        <label for="password_confirmation" style="display:block;font-weight:600;margin-bottom:6px;color:#333;">Confirm Password</label>
        <input 
            type="password" 
            id="password_confirmation" 
            name="password_confirmation" 
            style="width:100%;padding:10px;border:1px solid #ddd;border-radius:4px;font-size:14px;"
        />
    </div>

    <div style="grid-column:1/-1;">
        <label style="display:block;font-weight:600;margin-bottom:10px;color:#333;">Roles</label>
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
                <p style="color:#999;font-size:14px;">No roles available.</p>
            @endforelse
        </div>
    </div>
</div>
