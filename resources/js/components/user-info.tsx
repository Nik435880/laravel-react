import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { useInitials } from '@/hooks/use-initials';
import { User } from '@/types';

export function UserInfo({ user }: { user: User }) {
    const getInitials = useInitials();

    return (
        <div className="flex flex-row items-center gap-2">
            <Avatar className="h-8 w-8 overflow-hidden rounded-full">
                <AvatarImage
                    src={user.avatar ? `/storage/${user.avatar.avatar_path}` : ''}
                    alt={`${user.name}'s avatar`}
                />

                <AvatarFallback className="rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                    {getInitials(user.name)}
                </AvatarFallback>
            </Avatar>
            <div className="grid flex-1 text-left text-sm leading-tight">
                <span className="truncate font-medium text-md text-blue-500">{user.name}</span>
            </div>
        </div>
    );
}
