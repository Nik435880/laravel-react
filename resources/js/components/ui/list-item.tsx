import { Avatar, AvatarImage } from '@/components/ui/avatar';
import { Dialog, DialogTrigger, DialogContent, DialogTitle } from '@radix-ui/react-dialog';
import { DialogClose } from './dialog';
import { Button } from './button';
import { Message, Image } from '@/types';

export function ListItem({
    message
}: { message: Message }) {
    return (
        <li className='border-b last:border-b-0'>
            <div className='flex flex-col justify-center p-2 gap-1 '>
                <div className='flex flex-row items-center gap-1'>
                    <Avatar>
                        <AvatarImage src={message.user.avatar?.avatar_path ? `/storage/${message.user.avatar.avatar_path}` : `/storage/avatars/default.jpg`}
                            alt={`${message.user.name}`} />
                    </Avatar>
                    <h2 className='font-bold text-blue-500'>
                        {message.user.name}
                    </h2>
                </div>

                <p className='break-all'>
                    {message.text}
                </p>

                <div className='flex flex-row flex-wrap gap-2'>
                    {message.images.map((image: Image) => (
                        <Dialog key={image.id}>
                            <DialogTrigger asChild aria-label={`Open image ${image.id}`}>
                                <img src={`/storage/${image.image_path}`} alt={`Thumbnail ${image.id}`} className="w-48 h-48 object-cover rounded-md cursor-pointer" />
                            </DialogTrigger>

                            <DialogContent
                                className="fixed inset-0 p-4 flex items-center justify-center z-50"
                                aria-describedby={undefined}
                            >

                                <div className="absolute inset-0 bg-black opacity-75" />

                                <div className="relative z-10 w-full h-full max-w-4xl max-h-[90vh] p-4 flex flex-col gap-4 items-center justify-center rounded-md">
                                    <DialogTitle />


                                    <img
                                        src={`/storage/${image.image_path}`}
                                        alt={`Image ${image.id}`}
                                        className="rounded-md max-w-full max-h-full object-contain"
                                    />

                                    <DialogClose asChild>
                                        <Button type="button" variant="default" className=''>
                                            Close
                                        </Button>
                                    </DialogClose>
                                </div>
                            </DialogContent>
                        </Dialog>
                    ))}
                </div>

                <p className='text-gray-500 text-sm '>
                    {new Date(message.created_at).toLocaleString()}
                </p>
            </div>
        </li>
    );
}
