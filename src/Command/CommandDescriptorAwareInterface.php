<?php
declare(strict_types=1);

namespace IfCastle\TypeDefinitions\Command;

interface CommandDescriptorAwareInterface
{
    public function getCommandDescriptor(): ?CommandDescriptorInterface;
    
    public function setCommandDescriptor(CommandDescriptorInterface $commandDescriptor): static;
}