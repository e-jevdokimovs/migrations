<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information, see
 * <http://www.doctrine-project.org>.
 */

declare(strict_types=1);

namespace Doctrine\DBAL\Migrations;

/**
 * @since  1.6.0
 * @author Luís Cobucci <lcobucci@gmail.com>
 */
final class FileQueryWriter implements QueryWriter
{
    /**
     * @var string
     */
    private $columnName;

    /**
     * @var string
     */
    private $tableName;

    /**
     * @var null|OutputWriter
     */
    private $outputWriter;

    public function __construct(string $columnName, string $tableName, ?OutputWriter $outputWriter)
    {
        $this->columnName   = $columnName;
        $this->tableName    = $tableName;
        $this->outputWriter = $outputWriter;
    }

    /**
     * TODO: move SqlFileWriter's behaviour to this class - and kill it with fire (on the next major release)
     * @param string $path
     * @param string $direction
     * @param array $queriesByVersion
     * @return bool
     */
    public function write(string $path, string $direction, array $queriesByVersion) : bool
    {
        $writer = new SqlFileWriter(
            $this->columnName,
            $this->tableName,
            $path,
            $this->outputWriter
        );

        // SqlFileWriter#write() returns `bool|int` but all clients expect it to be `bool` only
        return (bool) $writer->write($queriesByVersion, $direction);
    }
}
