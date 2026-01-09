import AppLayout from '@/layouts/app-layout';
import { Head } from '@inertiajs/react';
import { User } from '@/types';
import { UsersTable } from '@/components/users-table';


export default function Dashboard({ users }: { users: User[] }) {
    return (
        <AppLayout>
            <Head title="Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <div className="border-sidebar-border/70 dark:border-sidebar-border relative min-h-[100vh] flex-1 overflow-hidden rounded-xl border md:min-h-min">
                    <UsersTable users={users} />
                </div>


            </div>
        </AppLayout>
    );
}
