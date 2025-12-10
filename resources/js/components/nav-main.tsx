import { SidebarGroup, SidebarGroupLabel, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { Link, usePage } from '@inertiajs/react';
import { Avatar, AvatarImage } from '@/components/ui/avatar';
import { Image } from 'lucide-react';
import { Rooms, Room } from '@/types';

export function NavMain({ items }: { items: Rooms[] }) {


    const { auth, url } = usePage().props as unknown as { auth: { user: { name: string, id: number } }, url: string };


    return (
        <SidebarGroup>
            <SidebarGroupLabel>Chats</SidebarGroupLabel>
            <SidebarMenu>
                {items?.map((room: Room) => {


                    const lastMessage = room.messages[room.messages.length - 1] || null;

                    const lastUser = lastMessage?.user;

                    const lastText = lastMessage?.text;

                    const roomName = room.users.find((user: { id: number; name: string; avatar: { avatar_path: string; }; }) => user.id !== auth.user.id)?.name;

                    const avatarPath = room.users.find((user: { id: number; name: string; avatar: { avatar_path: string; }; }) => user.id !== auth.user.id)?.avatar?.avatar_path;

                    return (
                        <SidebarMenuItem key={room.id} >
                            <SidebarMenuButton
                                asChild
                                isActive={`/rooms/${room.id}` === url}
                                tooltip={{ children: roomName }}
                            >
                                <Link href={`/rooms/${room.id}`} className='h-full w-full rounded-none'>
                                    <div className='flex flex-col h-full w-full items-start space-y-1'>
                                        <div className='flex flex-row items-center gap-1  '>
                                            <Avatar>
                                                <AvatarImage src={avatarPath ? `/storage/${avatarPath}` : '/storage/avatars/default.jpg'}
                                                    alt={`${roomName}'s avatar`} />
                                            </Avatar>
                                            <h1 className='text-xl font-bold'>{roomName}</h1>

                                        </div>



                                        <div className='flex flex-col items-center '>

                                            <h2 className='text-blue-500 font-semibold self-start'>{lastUser?.name}:</h2>

                                            <div className="flex items-center self-start gap-2 flex-wrap ">
                                                <p className="truncate">
                                                    {lastText}
                                                </p>


                                                {lastMessage?.images && lastMessage?.images.length > 0 && (
                                                    <div className="flex items-center">
                                                        <Image size={16} className="inline-block " />
                                                        <span className="text-gray-500 text-sm">
                                                            {lastMessage?.images.length}
                                                        </span>
                                                    </div>
                                                )}


                                            </div>

                                        </div>
                                        <span className='text-gray-400 text-sm '>{new Date(lastMessage?.created_at).toLocaleString() === 'Invalid Date' ? '' : new Date(lastMessage?.created_at).toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true }) || ''}</span>
                                    </div>
                                </Link>
                            </SidebarMenuButton>
                        </SidebarMenuItem>
                    );
                })}


            </SidebarMenu>
        </SidebarGroup>
    );
}
