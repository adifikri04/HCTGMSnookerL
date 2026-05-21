export const app = {};
export const db = {};
export const auth = {};
export const googleProvider = {};
export const serverTimestamp = () => new Date().toISOString();

export const onAuthStateChanged = async (auth, callback) => {
    try {
        const res = await fetch('api/auth.php?action=session');
        const data = await res.json();
        callback(data.user || null);
    } catch (e) {
        callback(null);
    }
};

export const signInWithEmailAndPassword = async (auth, email, password) => {
    const res = await fetch('api/auth.php?action=login', {
        method: 'POST',
        body: JSON.stringify({ email, password })
    });
    const data = await res.json();
    if (data.error) throw new Error(data.error);
    return { user: { uid: data.uid, email, displayName: data.displayName } };
};

export const createUserWithEmailAndPassword = async (auth, email, password) => {
    const res = await fetch('api/auth.php?action=signup', {
        method: 'POST',
        body: JSON.stringify({ email, password, displayName: 'Player' })
    });
    const data = await res.json();
    if (data.error) throw new Error(data.error);
    return { user: { uid: data.uid, email } };
};

export const signInWithPopup = async () => {
    throw new Error("Google Sign-In is disabled when using Local Database.");
};

export const signOut = async () => {
    await fetch('api/auth.php?action=logout');
};

export const doc = (db, col, id) => ({ col, id });
export const collection = (db, col) => ({ col });
export const query = (colRef, ...args) => ({ ...colRef, args });
export const where = (field, op, val) => ({ field, op, val });

export const getDoc = async (ref) => {
    if (ref.col === 'users') {
        const res = await fetch('api/profile.php');
        const data = await res.json();
        if (data.error) return { exists: () => false };
        return { exists: () => true, data: () => data };
    }
    return { exists: () => false };
};

export const setDoc = async (ref, data) => {
    if (ref.col === 'users') {
        await fetch('api/profile.php', { method: 'POST', body: JSON.stringify(data) });
    }
};

export const updateDoc = async (ref, data) => {
    if (ref.col === 'users') {
        await fetch('api/profile.php', { method: 'POST', body: JSON.stringify(data) });
    } else if (ref.col === 'bookings') {
        await fetch('api/bookings.php?action=update_status', { method: 'POST', body: JSON.stringify({ id: ref.id, ...data }) });
    } else if (ref.col === 'tournamentRegistrations') {
        await fetch('api/tournaments.php?action=update_status', { method: 'POST', body: JSON.stringify({ id: ref.id, ...data }) });
    }
};

export const deleteDoc = async (ref) => {
    if (ref.col === 'bookings') {
        await fetch('api/bookings.php?action=delete', { method: 'POST', body: JSON.stringify({ id: ref.id }) });
    } else if (ref.col === 'tournamentRegistrations') {
        await fetch('api/tournaments.php?action=delete', { method: 'POST', body: JSON.stringify({ id: ref.id }) });
    }
};

export const addDoc = async (ref, data) => {
    if (ref.col === 'bookings') {
        const res = await fetch('api/bookings.php?action=create', { method: 'POST', body: JSON.stringify(data) });
        const resData = await res.json();
        if (resData.error) throw new Error(resData.error);
    } else if (ref.col === 'tournamentRegistrations') {
        const res = await fetch('api/tournaments.php?action=create', { method: 'POST', body: JSON.stringify(data) });
        const resData = await res.json();
        if (resData.error) throw new Error(resData.error);
    }
};

export const getDocs = async (q) => {
    if (q.col === 'bookings') {
        const dateArg = q.args?.find(a => a.field === 'date')?.val;
        const tableArg = q.args?.find(a => a.field === 'tableId')?.val;
        if (dateArg && tableArg) {
            const res = await fetch(`api/bookings.php?action=check_slots&date=${dateArg}&tableId=${tableArg}`);
            const data = await res.json();
            return {
                docs: data.map(time => ({ data: () => ({ time, status: 'confirmed' }) }))
            };
        }
    }
    return { docs: [] };
};

export const onSnapshot = (ref, callback) => {
    const fetchData = async () => {
        let endpoint = '';
        if (ref.col === 'bookings') {
            const sess = await fetch('api/auth.php?action=session');
            const data = await sess.json();
            const user = data.user;
            // The HTML logic uses where('userId', '==', uid), but in PHP we automatically filter by session.
            // If they are an admin and the page is admin.html, it will list_all.
            endpoint = (window.location.pathname.includes('admin.html')) 
                ? 'api/bookings.php?action=list_all' 
                : 'api/bookings.php?action=list_user';
        } else if (ref.col === 'tournamentRegistrations') {
            endpoint = 'api/tournaments.php?action=list_all';
        }
        
        if (endpoint) {
            const res = await fetch(endpoint);
            const items = await res.json();
            if (!items.error && Array.isArray(items)) {
                callback({
                    forEach: (fn) => {
                        items.forEach(item => {
                            const timestamp = new Date(item.created_at).getTime();
                            item.createdAt = { toMillis: () => timestamp };
                            fn({ id: item.id, data: () => item });
                        });
                    }
                });
            }
        }
    };
    
    fetchData();
    const interval = setInterval(fetchData, 3000);
    return () => clearInterval(interval);
};
