import {
    Dialog,
    DialogTrigger,
    DialogContent,
    DialogTitle,
    DialogDescription,
    DialogHeader,
} from '@/components/ui/dialog';
import { MessageImage } from '@/components/message-image';
import { Message, Image } from '@/types';

export function MessageImages({ message }: { message: Message }) {
    return (
        <div className="flex flex-row flex-wrap gap-2 mt-1">
            {message?.images?.map((image: Image) => (
                <Dialog key={image.id}>
                    <DialogTrigger>
                        <MessageImage
                            image={image}
                            className="w-48 h-48 object-cover  cursor-pointer hover:opacity-75"
                        />
                    </DialogTrigger>

                    <DialogContent className="flex flex-col items-center p-0 m-0 justify-center bg-transparent shadow-none overflow-hidden border-none focus:ring-0 focus:ring-offset-0 focus:outline-none pointer-events-none ">
                        <DialogHeader>
                            <DialogTitle className="sr-only">Image {image.id}</DialogTitle>
                            <DialogDescription
                                id={`image-desc-${image.id}`}
                                className="sr-only"
                            >
                                Full view of image {image.id}
                            </DialogDescription>
                        </DialogHeader>

                        <MessageImage
                            image={image}
                            className="rounded-md max-w-full max-h-full object-contain object-center"
                            id={`image-${image.id}`}
                        />
                    </DialogContent>
                </Dialog>
            ))}
        </div>
    );
}
