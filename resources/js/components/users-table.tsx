import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { RoomForm } from '@/components/room-form';
import { User } from '@/types';
import { Avatar, AvatarImage } from '@/components/ui/avatar';
import { Tab } from '@headlessui/react';


export function UsersTable({ users }: { users: User[] }) {
    return (
        <Table>
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
                        <TableCell>
                            <div className="flex flex-row items-center gap-1">
                                <Avatar>
                                    <AvatarImage
                                        src={
                                            user.avatar?.avatar_path
                                                ? `/storage/${user.avatar.avatar_path}`
                                                : `/storage/avatars/default.jpg`
                                        }
                                        alt={`${user.name}`}
                                    />
                                </Avatar>
                                <h2 className="font-bold text-blue-500">{user.name}</h2>
                            </div>


                        </TableCell>
                        <TableCell>{user.email}</TableCell>
                        <TableCell>
                            <RoomForm user={user} />
                        </TableCell>
                    </TableRow>
                ))}
            </TableBody>
        </Table>
    );
}
