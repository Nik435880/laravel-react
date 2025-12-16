import AppLayout from '@/layouts/app-layout';
import { Head, usePage } from '@inertiajs/react';
import { type BreadcrumbItem, type SharedData } from '@/types';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';

import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/components/ui/dialog";
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { Form } from '@inertiajs/react'


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];


export default function Dashboard({ users }: { users: Array<{ id: number, name: string, email: string }> }) {

    const { errors } = usePage<SharedData>().props;

    return (
        <AppLayout breadcrumbs={breadcrumbs}>

            <Head title="Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <div className="grid auto-rows-min gap-4 md:grid-cols-3">
                    <div className="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border">

                    </div>

                </div>
                <div className="border-sidebar-border/70 dark:border-sidebar-border relative min-h-[100vh] flex-1 overflow-hidden rounded-xl border md:min-h-min">
                    <Table>
                        <TableCaption></TableCaption>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Name</TableHead>
                                <TableHead>Email</TableHead>
                                <TableHead>Action</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>

                            {users.map((user) => (
                                <TableRow key={user.id}>
                                    <TableCell >{user.name}</TableCell>
                                    <TableCell >{user.email}</TableCell>
                                    <TableCell>
                                        <Form action="/rooms" method='POST'
                                            transform={data => ({ ...data, name: user.name })}
                                        >
                                            <Button variant="outline">
                                                Send message
                                            </Button>
                                        </Form>


                                    </TableCell>
                                </TableRow>
                            ))}

                        </TableBody>
                    </Table>

                </div>
            </div>
        </AppLayout>
    );
}
